<?php

$bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application.php';
$serverRequest = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
/**
 * @var $response \Psr\Http\Message\ResponseInterface
 */
$response = $bootstrap->handle($serverRequest);

if ($response->getHeaderLine('Cache-Control') === 'public') {
    $ifModifiedSince = (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
    $etagHeader = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

    if ($ifModifiedSince === $response->getHeaderLine('Last-Modified') || $etagHeader === $response->getHeaderLine('ETag')) {
        header("HTTP/1.1 304 Not Modified");
        foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
            header($headerIdentifier . ': ' . implode(', ', $headerValue));
        }
        exit;
    }
}

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
print $response->getBody();
exit;