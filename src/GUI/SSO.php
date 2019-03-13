<?php


namespace rikmeijer\Teach\GUI;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\RouteEndPoint;

class SSO
{

    static function bootstrap(\rikmeijer\Teach\Bootstrap $bootstrap) : void {
        $bootstrap->router()->addRoute('^/sso/authorize', self::authorize($bootstrap));
        $bootstrap->router()->addRoute('^/sso/callback', self::callback($bootstrap));
        $bootstrap->router()->addRoute('^/logout', self::logout($bootstrap));
    }

    public static function authorize(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $server = $bootstrap->sso();
        return function(ServerRequestInterface $request) use ($server): RouteEndPoint
        {
            return new \rikmeijer\Teach\Routes\SSO\Authorize\TemporaryTokenCredentialsAcquisitionFactory($server);
        };
    }

    public static function callback(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $server = $bootstrap->sso();
        return function(ServerRequestInterface $request) use ($server): RouteEndPoint
        {
            $queryParams = $request->getQueryParams();

            if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
                return new Routes\SSO\Callback\TokenAuthorizationFactory($server, $queryParams['oauth_token'], $queryParams['oauth_verifier']);
            } else {
                return ErrorFactory::makeInstance(400);
            }
        };
    }

    public static function logout(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $user = $bootstrap->userForToken();
        return function(ServerRequestInterface $request) use ($user): RouteEndPoint
        {
            $user->logout();
            return new SeeOtherEndPoint('/');
        };
    }
}