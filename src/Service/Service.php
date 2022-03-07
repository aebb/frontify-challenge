<?php

namespace Frontify\ColorApi\Service;

use Frontify\ColorApi\Utils\Logger;

abstract class Service
{
    public const LOG_STARTED = 'STARTED REQUEST: %s';
    public const LOG_FINISH  = 'COMPLETED REQUEST: %s';
    public const LOG_QUERY   = 'RETRIEVED FROM DB %s';
    public const LOG_ERROR   = 'ERROR REQUEST %s';

    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
}
