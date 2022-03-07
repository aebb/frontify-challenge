<?php

declare(strict_types=1);

/* (c) Copyright Frontify Ltd., all rights reserved. */

namespace Frontify\ColorApi\Controller;

use Frontify\ColorApi\Request\Color\DeleteRequest;
use Frontify\ColorApi\Request\Color\GetRequest;
use Frontify\ColorApi\Request\Color\PostRequest;
use Frontify\ColorApi\Service\ColorService;
use Frontify\ColorApi\Utils\AppException;
use Frontify\ColorApi\Utils\HttpResponse;
use Frontify\ColorApi\Utils\Validator;
use Sunrise\Http\Message\Response;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Http\ServerRequest\ServerRequest;

class ColorController
{
    private ColorService $colorService;
    private Validator $validator;
    private ResponseFactory $responseFactory;

    public function __construct(ColorService $colorService, Validator $validator, ResponseFactory $responseFactory)
    {
        $this->colorService = $colorService;
        $this->validator = $validator;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @throws AppException
     */
    public function get(ServerRequest $request): Response
    {
        return $this->responseFactory->createJsonResponse(
            HttpResponse::HTTP_OK,
            $this->colorService->get($this->validator->validate(new GetRequest($request)))
        );
    }

    /**
     * @throws AppException
     */
    public function create(ServerRequest $request): Response
    {
        return $this->responseFactory->createJsonResponse(
            HttpResponse::HTTP_CREATED,
            $this->colorService->create($this->validator->validate(new PostRequest($request)))
        );
    }

    /**
     * @throws AppException
     */
    public function delete(ServerRequest $request): Response
    {
        return $this->responseFactory->createJsonResponse(
            HttpResponse::HTTP_OK,
            $this->colorService->delete($this->validator->validate(new DeleteRequest($request)))
        );
    }
}
