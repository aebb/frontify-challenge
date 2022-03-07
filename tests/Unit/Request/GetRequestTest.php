<?php

namespace Frontify\Tests\Unit\Request;

use Frontify\ColorApi\Request\Color\GetRequest;
use Frontify\ColorApi\Utils\AppException;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\ServerRequest\ServerRequest;
use Sunrise\Uri\Uri;

/**
 * @coversDefaultClass \Frontify\ColorApi\Request\Color\GetRequest
 */
class GetRequestTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getId
     * @covers ::getRequest
     */
    public function testRequest()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/1'));
        $sut = new GetRequest($request);

        $this->assertEquals(1, $sut->getId());
        $this->assertEquals($request, $sut->getRequest());
    }

    /**
     * @covers ::validate
     */
    public function testValidateEmpty()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/'));
        $sut = new GetRequest($request);

        try {
            $sut->validate();
        } catch (AppException $exception) {
            $this->assertEquals('id must be present', $exception->getMessage());
            $this->assertEquals(400, $exception->getStatusCode());
        }
    }

    /**
     * @covers ::validate
     */
    public function testValidateNotANumber()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/xpto'));
        $sut = new GetRequest($request);

        try {
            $sut->validate();
        } catch (AppException $exception) {
            $this->assertEquals('id must be an integer', $exception->getMessage());
            $this->assertEquals(400, $exception->getStatusCode());
        }
    }

    /**
     * @covers ::validate
     */
    public function testValidateSuccess()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/1'));
        $sut = new GetRequest($request);
        $this->assertTrue($sut->validate());
    }
}
