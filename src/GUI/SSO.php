<?php


namespace rikmeijer\Teach\GUI;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\ClosureEndPoint;
use rikmeijer\Teach\SeeOtherEndPoint;

class SSO
{

}

return function(\rikmeijer\Teach\Bootstrap $bootstrap) : void {
    $server = $bootstrap->sso();
    $user = $bootstrap->userForToken();

    $bootstrap->router()->addRoute('^/sso/authorize', function(ServerRequestInterface $request) use ($server): RouteEndPoint {
        return new SeeOtherEndPoint($server->acquireTemporaryCredentials());
    });
    $bootstrap->router()->addRoute('^/sso/callback', function(ServerRequestInterface $request) use ($server): RouteEndPoint {
        $queryParams = $request->getQueryParams();

        if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
            $server->authorizeTokenCredentials($queryParams['oauth_token'], $queryParams['oauth_verifier']);
            return new SeeOtherEndPoint('/');
        } else {
            return ErrorFactory::makeInstance(400);
        }
    });
    $bootstrap->router()->addRoute('^/logout', function(ServerRequestInterface $request) use ($user): RouteEndPoint {
        $user->logout();
        return new SeeOtherEndPoint('/');
    });
};