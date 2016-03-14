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

$interaction = new \Teach\Interactions\Document\HTML();
print $interaction->makeDocument($lesplanEntity->document($interaction))->render();