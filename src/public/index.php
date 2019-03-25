<?php

$bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application.php';
$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
/**
 * @var $response \Psr\Http\Message\ResponseInterface
 */
$response = $bootstrap->handle($serverRequest);

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
if ($response->getStatusCode() !== 304) {
    print $response->getBody();
}
exit;
