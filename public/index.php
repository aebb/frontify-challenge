<?php

declare(strict_types=1);

use Frontify\ColorApi\Controller\ColorController;
use Frontify\ColorApi\Repository\ColorRepository;
use Frontify\ColorApi\Service\ColorService;
use Frontify\ColorApi\Utils\ContainerRegistry;
use Frontify\ColorApi\Utils\Kernel;
use Frontify\ColorApi\Utils\Logger;
use Frontify\ColorApi\Utils\Routes;
use Frontify\ColorApi\Utils\Validator;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Http\ServerRequest\ServerRequestFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals();

$user =  $_SERVER['MYSQL_DATABASE_USER'];
$pass =  $_SERVER['MYSQL_DATABASE_PASSWORD'];
$dsn  =  $_SERVER['DB_DSN'];

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$conn = new PDO($dsn, $user, $pass, $options);

//dependencies - manual registration
$container = ContainerRegistry::getInstance();
$container->set('db', $conn);

$logger = new Logger();
$container->set('logger', $logger);

$colorRepository = new ColorRepository($conn);
$container->set('colorRepository', $colorRepository);

$validator = new Validator();
$container->set('validator', $validator);

$factory = new ResponseFactory();
$container->set('responseFactory', $factory);

$colorService = new ColorService($logger, $colorRepository);
$container->set('colorService', $colorService);

$endpoint = new ColorController($colorService, $validator, $factory);
$container->set('ColorController', $endpoint);

$kernel = new Kernel($container, $factory, Routes::ROUTES);

$message = $kernel->handle($request);
http_response_code($message->getStatusCode());
header('Content-Type: application/json');

echo $message->getBody();
