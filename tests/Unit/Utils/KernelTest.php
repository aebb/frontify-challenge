<?php

namespace Frontify\Tests\Unit\Utils;

use Frontify\ColorApi\Utils\ContainerRegistry;
use Frontify\ColorApi\Utils\Kernel;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Http\ServerRequest\ServerRequest;

/**
 * @coversDefaultClass \Frontify\ColorApi\Utils\Kernel
 */
class KernelTest extends TestCase
{
    protected ContainerRegistry $containerRegistry;

    protected ResponseFactory $responseFactory;

    protected Kernel $sut;

    public function setUp(): void
    {
        $this->containerRegistry = $this->createMock(ContainerRegistry::class);
        $this->responseFactory = new ResponseFactory();
        $routes = [
            [
                'url'         => '/aaa/',
                'http_method' => 'GET',
                'execute'     => 'get',
                'controller'  => 'ColorController'
            ]
        ];

        $this->sut = new Kernel($this->containerRegistry, $this->responseFactory, $routes);
    }

    /**
     * @covers ::handle
     */
    public function testErrorAppException()
    {
        $this->containerRegistry->method('get')->willReturn(null);

        $result = $this->sut->handle($this->createMock(ServerRequest::class));
        $this->assertEquals(500, $result->getStatusCode());
    }
}
