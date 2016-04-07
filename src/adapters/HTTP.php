<?php
namespace Teach\Adapters;

class HTTP
{
    public function handleRequest(array $server, array $get, array $post, array $cookie, array $files)
    {
        return new HTTP\Response();
    }
}