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
$contactmomentEntity = $applicationBootstrap->getDomainFactory()->createContactmoment($_GET['contactmoment']);
$lesplan = $applicationBootstrap->getInteractionFactory()->createInteraction($contactmomentEntity, $applicationBootstrap->createInteractionWeb());
if ($lesplan === null) {
    http_response_code(404);
    exit();
}

$HTMLfactory = new \Teach\Adapters\HTML\Factory();
print $HTMLfactory->renderTemplate(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'lesplan.php', $lesplan);