<?php namespace rikmeijer\Teach\Routes\SSO;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\Routes\SSO\Callback\Step1Factory;

class CallbackFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/sso/callback#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        $responseFactory = $this->resources->responseFactory();
        $session = $this->resources->session();
        $server = $this->resources->sso();

        $queryParams = $request->getQueryParams();

        if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
            return new Step1Factory($responseFactory, $session, $server, $queryParams['oauth_token'], $queryParams['oauth_verifier']);
        } else {
            return new Step2Factory($responseFactory, $session, $server);
        }
    }
}