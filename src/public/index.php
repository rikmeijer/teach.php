<?php

$bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application.php';
$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
$response = $bootstrap->handle($serverRequest);

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
print $response->getBody();
exit;