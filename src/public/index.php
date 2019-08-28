<?php

/**
 * @var $bootstrap \pulledbits\Bootstrap\Bootstrap
 */

use GuzzleHttp\Psr7\Response;

$bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application.php';
$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
/**
 * @var $response \Psr\Http\Message\ResponseInterface
 */
$response = $bootstrap->handle($serverRequest, new Response());

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
if ($response->getStatusCode() !== 304) {
    print $response->getBody();
}
exit;
