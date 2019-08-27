<?php

namespace rikmeijer\Teach;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Bootstrap\Bootstrap;

return new class
{

    /**
     * @var Bootstrap
     */
    private $bootstrap;

    public function __construct()
    {
        $this->bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    }

    public function handle(\Psr\Http\Message\ServerRequestInterface $serverRequest): ResponseInterface
    {
        $matcher = $this->bootstrap->resource('router');
        $route = $matcher->match($serverRequest);
        if (!$route) {
            return new Response(404);
        }
        foreach ($route->attributes as $key => $val) {
            $serverRequest = $serverRequest->withAttribute($key, $val);
        }
        return ($route->handler)($serverRequest, new Response());
    }

    public function root() : string {
        return dirname(__DIR__);
    }
};
