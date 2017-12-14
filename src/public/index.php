<?php

$bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application.php';
$routeEndPoint = $bootstrap->handle();

$response = $routeEndPoint->respond(new \pulledbits\Response\Factory());

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
print $response->getBody();
exit;