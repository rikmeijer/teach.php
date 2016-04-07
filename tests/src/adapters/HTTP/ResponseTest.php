<?php
namespace Teach\Adapters\HTTP;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testHandleRequest()
    {
        $response = new Response();
        $stream = fopen("php://memory", "wb");
        $response->send($stream);
        rewind($stream);
        $data = stream_get_contents($stream);
        $this->assertEquals('', $data);
    }
}