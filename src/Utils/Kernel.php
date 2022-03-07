<?php

namespace Frontify\ColorApi\Utils;

use Exception;
use Sunrise\Http\Message\Response;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Http\ServerRequest\ServerRequest;

/**
 * @codeCoverageIgnore
 */
class Kernel
{
    public const NO_ROUTE_ERROR_MESSAGE = 'no route found';

    protected ContainerRegistry $containerRegistry;

    protected ResponseFactory $responseFactory;

    protected array $routes;

    public function __construct(ContainerRegistry $containerRegistry, ResponseFactory $responseFactory, array $routes)
    {
        $this->containerRegistry = $containerRegistry;
        $this->responseFactory = $responseFactory;
        $this->routes = $routes;
    }

    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function handle(ServerRequest $request): Response
    {
        try {
            foreach ($this->routes as $endpoint) {
                //check if request url matches any route and http method and callable function
                $controller =  $this->containerRegistry->get($endpoint['controller']);
                if (
                    $controller
                    && preg_match($endpoint['url'], $request->getUri()->getPath())
                    && $endpoint['http_method'] === $request->getMethod()
                    && is_callable([$controller, $endpoint['execute']])
                ) {
                    $method = $endpoint['execute'];
                    return $controller->$method($request);
                }
            }
            throw new AppException(self::NO_ROUTE_ERROR_MESSAGE);
        } catch (AppException $appException) {
            return $this->responseFactory->createJsonResponse($appException->getStatusCode(), $appException);
        } catch (Exception $exception) {
            $appException = new AppException();
            return $this->responseFactory->createJsonResponse($appException->getStatusCode(), $appException);
        }
    }
}
