<?php

namespace Frontify\Tests\Unit\Service;

use Frontify\ColorApi\Entity\Color;
use Frontify\ColorApi\Repository\ColorRepository;
use Frontify\ColorApi\Request\Color\DeleteRequest;
use Frontify\ColorApi\Request\Color\GetRequest;
use Frontify\ColorApi\Request\Color\PostRequest;
use Frontify\ColorApi\Service\ColorService;
use Frontify\ColorApi\Utils\AppException;
use Frontify\ColorApi\Utils\Logger;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\ServerRequest\ServerRequest;
use Sunrise\Stream\StreamFactory;
use Sunrise\Uri\Uri;

/**
 * @coversDefaultClass \Frontify\ColorApi\Service\ColorService
 */
class ColorServiceTest extends TestCase
{
    protected ColorRepository $repository;
    protected Logger $logger;
    protected ColorService $sut;


    /**
     * @covers ::__construct
     */
    public function setUp(): void
    {
        $this->repository = $this->createMock(ColorRepository::class);
        $this->logger = $this->createMock(Logger::class);
        $this->logger->method('log')->willReturn('');

        $this->sut = new ColorService($this->logger, $this->repository);
    }

    /**
     * @covers ::__construct
     * @covers ::get
     */
    public function testGetNotFound()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/1'));
        $this->repository->expects($this->once())
            ->method('getColorById')
            ->with(1)
            ->willReturn(null);

        try {
            $this->sut->get(new GetRequest($request));
        } catch (AppException $exception) {
            $this->assertEquals(404, $exception->getStatusCode());
            $this->assertEquals('color not found', $exception->getMessage());
        }
    }

    /**
     * @covers ::__construct
     * @covers ::get
     */
    public function testGetSuccess()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/1'));

        $color = $this->createMock(Color::class);
        $this->repository->expects($this->once())
            ->method('getColorById')
            ->with(1)
            ->willReturn($color);

        $this->assertEquals($color, $this->sut->get(new GetRequest($request)));
    }

    /**
     * @covers ::__construct
     * @covers ::create
     */
    public function testPostFound()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path'));
        $request->method('getBody')->willReturn((new StreamFactory())->createStream('{
            "name": "Green",
            "hexCode": "#00FF00"
        }'));

        $this->repository->expects($this->once())
            ->method('getColorByName')
            ->with('Green')
            ->willReturn($this->createMock(Color::class));

        try {
            $this->sut->create(new PostRequest($request));
        } catch (AppException $exception) {
            $this->assertEquals(409, $exception->getStatusCode());
            $this->assertEquals('color already exists', $exception->getMessage());
        }
    }

    /**
     * @covers ::__construct*
     * @covers ::create
     */
    public function testPostSuccess()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path'));
        $request->method('getBody')->willReturn((new StreamFactory())->createStream('{
            "name": "Green",
            "hexCode": "#00FF00"
        }'));

        $expected = $this->createMock(Color::class);

        $this->repository->expects($this->once())
            ->method('getColorByName')
            ->with('Green')
            ->willReturn(null);

        $this->repository->expects($this->once())
            ->method('create')
            ->willReturn($expected);

        $this->assertEquals($expected, $this->sut->create(new PostRequest($request)));
    }

    /**
     * @covers ::__construct
     * @covers ::delete
     */
    public function testDeleteNotFound()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/1'));
        $this->repository->expects($this->once())
            ->method('getColorById')
            ->with(1)
            ->willReturn(null);

        try {
            $this->sut->delete(new DeleteRequest($request));
        } catch (AppException $exception) {
            $this->assertEquals(404, $exception->getStatusCode());
            $this->assertEquals('color not found', $exception->getMessage());
        }
    }

    /**
     * @covers ::delete
     * @covers ::__construct
     */
    public function testDeleteSuccess()
    {
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn(new Uri('path/1'));

        $color = $this->createMock(Color::class);
        $this->repository->expects($this->once())
            ->method('getColorById')
            ->with(1)
            ->willReturn($color);

        $this->repository->expects($this->once())
            ->method('delete')
            ->with($color)
            ->willReturn($color);

        $this->assertEquals($color, $this->sut->delete(new DeleteRequest($request)));
    }
}
