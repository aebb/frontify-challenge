<?php

namespace Frontify\ColorApi\Request;

use Sunrise\Http\ServerRequest\ServerRequest;

abstract class Request
{
    protected ServerRequest $request;

    public function __construct(ServerRequest $request)
    {
        $this->request = $request;
    }

    public function getRequest(): ServerRequest
    {
        return $this->request;
    }

    abstract public function validate(): bool;
}
