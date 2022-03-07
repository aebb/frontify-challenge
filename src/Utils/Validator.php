<?php

namespace Frontify\ColorApi\Utils;

use Frontify\ColorApi\Request\Request;

class Validator
{
    public function __construct()
    {
    }

    public function validate(Request $request): Request
    {
        $request->validate();
        return $request;
    }
}
