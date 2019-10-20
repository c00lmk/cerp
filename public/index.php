<?php
declare(strict_types=1);

use CERP\HelloWorld;
use DI\ContainerBuilder;
use Relay\Relay;
use Zend\Diactoros\ServerRequestFactory;
use function DI\create;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    HelloWorld::class => create(HelloWorld::class)
]);

$container = $containerBuilder->build();

$middlewareQueue = [];
$requestHandler = new Relay($middlewareQueue);
$requestHandler->handle(ServerRequestFactory::fromGlobals());


$helloWorld = $container->get(HelloWorld::class);
$helloWorld->announce();