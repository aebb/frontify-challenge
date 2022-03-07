<?php

namespace Frontify\Tests\Unit\Repository;

use Exception;
use Frontify\ColorApi\Entity\Color;
use Frontify\ColorApi\Repository\ColorRepository;
use Frontify\ColorApi\Utils\AppException;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Frontify\ColorApi\Repository\ColorRepository
 */
class ColorRepositoryTest extends TestCase
{
    protected PDO $pdo;

    protected ColorRepository $sut;

    public function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->sut = new ColorRepository($this->pdo);
    }

    /**
     * @covers ::getColorById
     */
    public function testGetColorById()
    {
        $id = 1;
        $query = 'SELECT * FROM color WHERE id = :id';
        $preparedStatement = $this->createMock(PDOStatement::class);
        $params = ['id' => $id];

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($query)
            ->willReturn($preparedStatement);

        $preparedStatement->expects($this->once())
            ->method('execute')
            ->with($params);

        $preparedStatement->expects($this->once())
            ->method('fetch')
            ->willReturn(['id' => $id, 'name' => 'foo', 'hexCode' => '#ffffff']);

        $this->assertTrue($this->sut->getColorById($id) instanceof Color);
    }

    /**
     * @covers ::getColorByName
     */
    public function testGetColorByName()
    {
        $id = 1;
        $name = 'foo';
        $query = 'SELECT * FROM color WHERE name = :name';
        $preparedStatement = $this->createMock(PDOStatement::class);
        $params = ['name' => $name];

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($query)
            ->willReturn($preparedStatement);

        $preparedStatement->expects($this->once())
            ->method('execute')
            ->with($params);

        $preparedStatement->expects($this->once())
            ->method('fetch')
            ->willReturn(['id' => $id, 'name' => $name, 'hexCode' => '#ffffff']);

        $this->assertTrue($this->sut->getColorByName($name) instanceof Color);
    }

    /**
     * @covers ::create
     */
    public function testCreateColor()
    {
        $id = 1;
        $name = 'foo';
        $hex = '#ffffff';
        $input = ['id' => $id, 'name' => $name, 'hexCode' => $hex];
        $color = new Color($input);

        $query = 'INSERT INTO color(name,hexCode) values(:name,:hexCode)';
        $preparedStatement = $this->createMock(PDOStatement::class);

        $this->pdo->expects($this->once())
            ->method('beginTransaction');

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($query)
            ->willReturn($preparedStatement);

        $preparedStatement->expects($this->once())
            ->method('execute')
            ->with(['name' => $color->getName(), 'hexCode' => $color->getHexCode()]);

        $this->pdo->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

        $this->pdo->expects($this->once())
            ->method('commit');

        $this->assertTrue($this->sut->create($color) instanceof Color);
    }

    public function testCreateError()
    {
        $this->pdo->expects($this->once())
            ->method('beginTransaction')
            ->willThrowException(new Exception());

        $this->pdo->expects($this->once())
            ->method('rollback');

        try {
            $this->sut->create($this->createMock(Color::class));
        } catch (AppException $exception) {
            $this->assertEquals(500, $exception->getStatusCode());
            $this->assertEquals('Unexpected error', $exception->getMessage());
        }
    }

    /**
     * @covers ::delete
     */
    public function testDeleteColor()
    {
        $id = 1;
        $name = 'foo';
        $hex = '#ffffff';
        $input = ['id' => $id, 'name' => $name, 'hexCode' => $hex];
        $color = new Color($input);

        $query = 'DELETE FROM color WHERE id = :id';
        $preparedStatement = $this->createMock(PDOStatement::class);

        $this->pdo->expects($this->once())
            ->method('beginTransaction');

        $this->pdo->expects($this->once())
            ->method('prepare')
            ->with($query)
            ->willReturn($preparedStatement);

        $preparedStatement->expects($this->once())
            ->method('execute')
            ->with(['id' => $color->getId()]);

        $this->pdo->expects($this->once())
            ->method('commit');

        $this->assertTrue($this->sut->delete($color) instanceof Color);
    }

    /**
     * @covers ::delete
     */
    public function testDeleteError()
    {
        $this->pdo->expects($this->once())
            ->method('beginTransaction')
            ->willThrowException(new Exception());

        $this->pdo->expects($this->once())
            ->method('rollback');

        try {
            $this->sut->delete($this->createMock(Color::class));
        } catch (AppException $exception) {
            $this->assertEquals(500, $exception->getStatusCode());
            $this->assertEquals('Unexpected error', $exception->getMessage());
        }
    }
}
