<?php

namespace Frontify\Tests\Unit\Controller;

use Frontify\ColorApi\Controller\ColorController;
use Frontify\ColorApi\Entity\Color;
use Frontify\ColorApi\Service\ColorService;
use Frontify\ColorApi\Utils\Validator;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Http\ServerRequest\ServerRequest;
use Sunrise\Stream\StreamFactory;
use Sunrise\Uri\Uri;

/**
 * @coversDefaultClass \Frontify\ColorApi\Controller\ColorController
 */
class ColorControllerTest extends TestCase
{
    protected ColorService $service;

    protected Validator $validator;

    protected ResponseFactory $responseFactory;

    protected ColorController $sut;

    public function setUp(): void
    {
        $this->service = $this->createMock(ColorService::class);
        $this->validator = new Validator();
        $this->responseFactory = new ResponseFactory();

        $this->sut = new ColorController($this->service, $this->validator, $this->responseFactory);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     */
    public function testGet()
    {
        $color =  $this->createMock(Color::class);
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/1'));

        $this->service->expects($this->once())->method('get')->willReturn($color);

        $result = $this->sut->get($request);
        $this->assertEquals(200, $result->getStatusCode());
    }

    /**
     * @covers ::__construct
     * @covers ::post
     */
    public function testPost()
    {
        $color =  $this->createMock(Color::class);
        $request = $this->createMock(ServerRequest::class);
        $request->method('getBody')->willReturn((new StreamFactory())->createStream('{
            "name": "Green",
            "hexCode": "#00FF00"
        }'));

        $this->service->expects($this->once())->method('create')->willReturn($color);

        $result = $this->sut->create($request);
        $this->assertEquals(201, $result->getStatusCode());
    }

    /**
     * @covers ::__construct
     * @covers ::delete
     */
    public function testDelete()
    {
        $color =  $this->createMock(Color::class);
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/1'));

        $this->service->expects($this->once())->method('delete')->willReturn($color);

        $result = $this->sut->delete($request);
        $this->assertEquals(200, $result->getStatusCode());
    }
}
