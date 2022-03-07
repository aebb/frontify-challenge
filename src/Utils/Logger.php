<?php

namespace Frontify\ColorApi\Utils;

class Logger
{
    public const LOGGER_INFO    = 1;
    public const LOGGER_WARNING = 2;
    public const LOGGER_ERROR   = 3;

    public function __construct()
    {
    }

    public function log(int $level, string $message): string
    {
        return $level . $message;
    }
}
