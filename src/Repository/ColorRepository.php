<?php

namespace Frontify\ColorApi\Repository;

use Exception;
use Frontify\ColorApi\Entity\Color;
use Frontify\ColorApi\Utils\AppException;
use PDO;

class ColorRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getColorById(int $id): ?Color
    {
        $query = 'SELECT * FROM color WHERE id = :id';
        $preparedStatement = $this->pdo->prepare($query);
        $preparedStatement->execute(['id' => $id]);

        $result = $preparedStatement->fetch();
        return $result ? new Color($result) : null;
    }

    public function getColorByName(string $name): ?Color
    {
        $query = 'SELECT * FROM color WHERE name = :name';
        $preparedStatement = $this->pdo->prepare($query);
        $preparedStatement->execute(['name' => $name]);

        $result = $preparedStatement->fetch();
        return $result ? new Color($result) : null;
    }

    /**
     * @throws AppException
     */
    public function create(Color $color): ?Color
    {
        try {
            $this->pdo->beginTransaction();

            $query = 'INSERT INTO color(name,hexCode) values(:name,:hexCode)';
            $preparedStatement = $this->pdo->prepare($query);
            $preparedStatement->execute(['name' => $color->getName(), 'hexCode' => $color->getHexCode()]);

            $color->setId($this->pdo->lastInsertId());
            $this->pdo->commit();
        } catch (Exception $exception) {
            $this->pdo->rollback();
            throw new AppException();
        }

        return $color;
    }

    /**
     * @throws AppException
     */
    public function delete(Color $color): ?Color
    {
        try {
            $this->pdo->beginTransaction();

            $query = 'DELETE FROM color WHERE id = :id';
            $preparedStatement = $this->pdo->prepare($query);
            $preparedStatement->execute(['id' => $color->getId()]);

            $this->pdo->commit();
        } catch (Exception $exception) {
            $this->pdo->rollback();
            throw new AppException();
        }

        return $color;
    }
}
