<?php

$bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application.php';
$routeEndPoint = $bootstrap->handle(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

$response = $routeEndPoint->respond(new class implements \pulledbits\Router\ResponseFactory {

    public function make(string $statusCode, string $body): \Psr\Http\Message\ResponseInterface
    {
        $response = (new \GuzzleHttp\Psr7\Response($statusCode))->withBody(\GuzzleHttp\Psr7\stream_for($body));
        $finfo = new \finfo(FILEINFO_MIME);
        return $response->withHeader('Content-Type', $finfo->buffer($body));
    }

    public function makeWithHeaders(string $statusCode, array $headers, string $body): \Psr\Http\Message\ResponseInterface
    {
        $response = $this->make($statusCode, $body);
        foreach ($headers as $headerIdentifier => $headerValue) {
            $response = $response->withHeader($headerIdentifier, $headerValue);
        }
        return $response;
    }

    public function makeWithTemplate(string $statusCode, \pulledbits\View\TemplateInstance $templateInstance): \Psr\Http\Message\ResponseInterface
    {
        return $this->make($statusCode, $templateInstance->capture());
    }
});

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $headerIdentifier => $headerValue) {
    header($headerIdentifier . ': ' . implode(', ', $headerValue));
}
print $response->getBody();
exit;