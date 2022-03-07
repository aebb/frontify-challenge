<?php

namespace Frontify\ColorApi\Utils;

class Routes
{
    public const ROUTES = [
        [
            'url'         => '/^\/colors\/[0-9]*$/',
            'http_method' => 'GET',
            'execute'     => 'get',
            'controller'  => 'ColorController'
        ],
        [
            'url'         => '/^\/colors$/',
            'http_method' => 'POST',
            'execute'     => 'create',
            'controller'  => 'ColorController'
        ],
        [
            'url'         => '/^\/colors\/[0-9]*$/',
            'http_method' => 'DELETE',
            'execute'     => 'delete',
            'controller'  => 'ColorController'
        ],
//        [
//            'url'         => '/\/colors\/[0-9]*/',
//            'http_method' => 'PUT',
//            'execute'     => 'update',
//            'controller'  => 'ColorController'
//        ],
    ];
}
