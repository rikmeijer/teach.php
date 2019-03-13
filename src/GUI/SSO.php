<?php


namespace rikmeijer\Teach\GUI;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\ClosureEndPoint;
use rikmeijer\Teach\SeeOtherEndPoint;

class SSO
{
    private $session;
    private $server;

    public function __construct(\League\OAuth1\Client\Server\Server $server, \Aura\Session\Session $session)
    {
        $this->server = $server;
        $this->session = $session;
    }


    public function acquireTemporaryCredentials() : string
    {
        $temporaryCredentials = $this->server->getTemporaryCredentials();
        $this->session->getSegment('token')->set('temporary_credentials', serialize($temporaryCredentials));
        return $this->server->getAuthorizationUrl($temporaryCredentials);
    }

    public function authorizeTokenCredentials(string $oauthToken, string $oauthVerifier) : void
    {
        $temporaryCredentialsSerialized = $this->session->getSegment('token')->get('temporary_credentials');
        if ($temporaryCredentialsSerialized !== null) {
            $temporaryCredentials = unserialize($temporaryCredentialsSerialized);
            $tokenCredentials = $this->server->getTokenCredentials($temporaryCredentials, $oauthToken, $oauthVerifier);
            $this->session->getSegment('token')->set('temporary_credentials', null);
            $this->session->getSegment('token')->set('credentials', serialize($tokenCredentials));
        }
    }

    public function logout() : void
    {
        if ($this->session->isStarted()) {
            $this->session->getSegment('token')->clear();
            $this->session->clear();
            $this->session->destroy();
        }
    }
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap) : void {
    $sso = new \rikmeijer\Teach\GUI\SSO($bootstrap->oauthServer(), $bootstrap->session());

    $bootstrap->router()->addRoute('^/sso/authorize', function(ServerRequestInterface $request) use ($sso): RouteEndPoint {
        return new SeeOtherEndPoint($sso->acquireTemporaryCredentials());
    });
    $bootstrap->router()->addRoute('^/sso/callback', function(ServerRequestInterface $request) use ($sso): RouteEndPoint {
        $queryParams = $request->getQueryParams();

        if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
            $sso->authorizeTokenCredentials($queryParams['oauth_token'], $queryParams['oauth_verifier']);
            return new SeeOtherEndPoint('/');
        } else {
            return ErrorFactory::makeInstance(400);
        }
    });
    $bootstrap->router()->addRoute('^/logout', function(ServerRequestInterface $request) use ($sso): RouteEndPoint {
        $sso->logout();
        return new SeeOtherEndPoint('/');
    });
};