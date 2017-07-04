<?php
namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;

class Response
{
    public function make(int $status, string $body) : ResponseInterface
    {
        return (new \GuzzleHttp\Psr7\Response($status))->withBody(\GuzzleHttp\Psr7\stream_for($body));
    }

    public function makeWithHeaders(int $status, array $headers, string $body) : ResponseInterface
    {
        $response = $this->make($status, $body);
        foreach ($headers as $headerIdentifier => $headerValue) {
            $response = $response->withHeader($headerIdentifier, $headerValue);
        }
        return $response;

    }
}