<?php
$bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application.php';
$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
$response = $bootstrap->handle($serverRequest);
http_response_code($response['status']);
foreach ($response['headers'] as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
print $response['body'];
exit;