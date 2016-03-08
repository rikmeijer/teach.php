<?php
if (array_key_exists('contactmoment', $_GET) === false) {
    http_response_code(400);
    exit();
}

/**
 * 
 * @var \ApplicationBootstrap $applicationBootstrap
 */
$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$lesplanEntity = $applicationBootstrap->getDomainFactory()->createLesplan($_GET['contactmoment']);
$lesplan = $lesplanEntity->interact($applicationBootstrap->createInteractionWeb());
if ($lesplan === null) {
    http_response_code(404);
    exit();
}

$HTMLfactory = new \Teach\Adapters\HTML\Factory(__DIR__ . DIRECTORY_SEPARATOR . 'templates');
print $lesplan->present($HTMLfactory);