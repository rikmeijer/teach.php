<?php
namespace Teach\Adapters;

class HTTPTest extends \PHPUnit_Framework_TestCase
{

    public function testHandleRequest()
    {
        $http = new HTTP();
        
        $response = $http->handleRequest([], [], [], [], []); // array $server, array $get, array $post, array $cookie, array $files
    }
}