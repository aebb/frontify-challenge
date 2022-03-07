<?php

namespace Frontify\ColorApi\Utils;

class ErrorCode
{
    public const ERROR_CODE_GET_COLORS = 1;
    public const ERROR_CODE_CREATE_COLORS = 2;
    public const ERROR_CODE_DELETE_COLORS = 3;
    public const ERROR_CODE_UPDATE_COLORS = 4;

    public const COLOR_NOT_FOUND = 'color not found';
    public const DUPLICATE_COLOR_NAME = 'color already exists';
}
