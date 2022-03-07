<?php

namespace Frontify\Tests\Unit\Request;

use Frontify\ColorApi\Request\Color\PostRequest;
use Frontify\ColorApi\Utils\AppException;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\ServerRequest\ServerRequest;
use Sunrise\Stream\StreamFactory;
use Sunrise\Uri\Uri;

/**
 * @coversDefaultClass \Frontify\ColorApi\Request\Color\PostRequest
 */
class PostRequestTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getHexCode
     * @covers ::getName
     * @covers ::getRequest
     */
    public function testRequest()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getBody')->willReturn((new StreamFactory())->createStream('{
            "name": "Green",
            "hexCode": "#00FF00"
        }'));
        $sut = new PostRequest($request);

        $this->assertEquals('Green', $sut->getName());
        $this->assertEquals('#00FF00', $sut->getHexCode());
        $this->assertEquals($request, $sut->getRequest());
    }

    /**
     * @covers ::validate
     * @covers ::validateHexCode
     * @covers ::validateName
     */
    public function testValidateNameEmpty()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getBody')->willReturn((new StreamFactory())->createStream('{
            "hexCode": "#00FF00"
        }'));
        $sut = new PostRequest($request);

        try {
            $sut->validate();
        } catch (AppException $exception) {
            $this->assertEquals('name must be present', $exception->getMessage());
            $this->assertEquals(400, $exception->getStatusCode());
        }
    }

    /**
     * @covers ::validate
     * @covers ::validateHexCode
     * @covers ::validateName
     */
    public function testValidateNameSize()
    {
        $name = 'GreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreen' .
            'GreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreen' .
            'GreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreen' .
            'GreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreen' .
            'GreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreenGreen';
        $request = $this->createMock(ServerRequest::class);
        $body = sprintf('{
            "name": "%s",
            "hexCode": "#00FF00"
        }', $name);
        $request->method('getBody')->willReturn((new StreamFactory())->createStream($body));
        $sut = new PostRequest($request);

        try {
            $sut->validate();
        } catch (AppException $exception) {
            $this->assertEquals('name must be 0-255 chars long', $exception->getMessage());
            $this->assertEquals(400, $exception->getStatusCode());
        }
    }
    /**
     * @covers ::validate
     * @covers ::validateHexCode
     * @covers ::validateName
     */
    public function testValidateHexEmpty()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getBody')->willReturn((new StreamFactory())->createStream('{
            "name": "Green"
        }'));
        $sut = new PostRequest($request);

        try {
            $sut->validate();
        } catch (AppException $exception) {
            $this->assertEquals('hexCode must be present', $exception->getMessage());
            $this->assertEquals(400, $exception->getStatusCode());
        }
    }

    /**
     * @covers ::validate
     * @covers ::validateHexCode
     * @covers ::validateName
     */
    public function testValidateHexValue()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getBody')->willReturn((new StreamFactory())->createStream('{
            "name": "Green",
            "hexCode": "#ff"
        }'));
        $sut = new PostRequest($request);

        try {
            $sut->validate();
        } catch (AppException $exception) {
            $this->assertEquals('invalid hexCode pattern', $exception->getMessage());
            $this->assertEquals(400, $exception->getStatusCode());
        }
    }

    /**
     * @covers ::validate
     * @covers ::validateHexCode
     * @covers ::validateName
     */
    public function testValidateSuccess()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getBody')->willReturn((new StreamFactory())->createStream('{
            "name": "Green",
            "hexCode": "#fff"
        }'));
        $sut = new PostRequest($request);
        $this->assertTrue($sut->validate());
    }
}
