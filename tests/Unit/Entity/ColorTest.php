<?php

namespace Frontify\Tests\Unit\Entity;

use Frontify\ColorApi\Entity\Color;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Frontify\ColorApi\Entity\Color
 */
class ColorTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::jsonSerialize
     */
    public function testJson()
    {
        $id = 1;
        $name = 'white';
        $hex = '#FFFFFF';
        $createdAt = '2020-01-01 00:00:00';
        $updatedAt = '2020-01-01 00:00:00';

        $input = [
            'id'        => $id,
            'name'      => $name,
            'hexCode'   => $hex,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt
        ];
        $model = new Color($input);
        $this->assertEquals($input, $model->jsonSerialize());
    }

    /**
     * @covers ::__construct
     * @covers ::getId
     * @covers ::getName
     * @covers ::getHexCode
     * @covers ::getCreatedAt
     * @covers ::getUpdatedAt
     * @covers ::setId
     * @covers ::__toString
     */
    public function testGettersSetters()
    {
        $id = 1;
        $name = 'white';
        $hex = '#FFFFFF';
        $createdAt = '2020-01-01 00:00:00';
        $updatedAt = '2020-01-01 00:00:00';

        $input = [
            'id'        => $id + 1,
            'name'      => $name,
            'hexCode'   => $hex,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt
        ];

        $model = new Color($input);
        $this->assertEquals($id + 1, $model->getId());

        $model->setId($id);
        $this->assertEquals($id, $model->getId());
        $this->assertEquals($name, $model->getName());
        $this->assertEquals($hex, $model->getHexCode());
        $this->assertEquals($createdAt, $model->getCreatedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals($updatedAt, $model->getUpdatedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals($name, $model->__toString());
    }
}
