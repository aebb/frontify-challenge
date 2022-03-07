<?php

namespace Frontify\Tests\Unit\Utils;

use Frontify\ColorApi\Request\Color\GetRequest;
use Frontify\ColorApi\Utils\Validator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Frontify\ColorApi\Utils\Validator
 */
class ValidatorTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::validate
     */
    public function testValidate()
    {
        $request = $this->createMock(GetRequest::class);
        $request->expects($this->once())->method('validate')->willReturn(true);

        $sut = new Validator();
        $this->assertEquals($request, $sut->validate($request));
    }
}
