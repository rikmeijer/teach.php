<?php

$bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application.php';
$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
$routeEndPoint = $bootstrap->handle($serverRequest);
switch ($serverRequest->getMethod()) {
    case 'POST':
        $responseCode = '201';
        break;
    default:
        $responseCode = '200';
        break;
}
$response = $routeEndPoint->respond(new \pulledbits\Router\ResponseFactory($responseCode));

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
print $response->getBody();
exit;