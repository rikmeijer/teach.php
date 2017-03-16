<?php

namespace {

    use rikmeijer\Teach\Request;

    return function (callable $responseSender): \Psr\Http\Message\ResponseInterface {
        /**
         * @var $resources \rikmeijer\Teach\Bootstrap
         */
        $bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

        $rawRequest = $bootstrap->request();
        $route = $bootstrap->route($rawRequest);

        foreach ($route->attributes as $attributeIdentifier => $attributeValue) {
            $rawRequest = $rawRequest->withAttribute($attributeIdentifier, $attributeValue);
        }

        $request = new Request($rawRequest, $bootstrap->response($responseSender));

        if ($route === false) {
            $request->respond(404, 'Failure');
        } else {
            call_user_func($route->handler, $bootstrap->resources(), $request);
        }
    };
}