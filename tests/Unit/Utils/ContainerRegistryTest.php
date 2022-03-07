<?php

namespace Frontify\Tests\Unit\Utils;

use Frontify\ColorApi\Utils\ContainerRegistry;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Frontify\ColorApi\Utils\ContainerRegistry
 */
class ContainerRegistryTest extends TestCase
{
    /**
     * @covers ::getInstance
     * @covers ::get
     * @covers ::set
     * @covers ::__construct
     */
    public function testContainer()
    {
        $key = 'foo';
        $service = 'bar';

        $sut = ContainerRegistry::getInstance();

        $sut->set($key, $service);
        $this->assertEquals($sut->get($key), $service);
        $this->assertNull($sut->get($service));
    }
}
