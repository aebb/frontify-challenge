<?php

namespace Frontify\Tests\Unit\Utils;

use Frontify\ColorApi\Utils\AppException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Frontify\ColorApi\Utils\AppException
 */
class AppExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getStatusCode
     * @covers ::jsonSerialize
     */
    public function testAppException()
    {
        $sut = new AppException();
        $expected = ['errorCode' => 0,'message' => 'Unexpected error'];

        $this->assertEquals(500, $sut->getStatusCode());
        $this->assertEquals($expected, $sut->jsonSerialize());
    }
}
