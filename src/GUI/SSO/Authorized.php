<?php


namespace rikmeijer\Teach\GUI\SSO;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;

class Authorized implements Route
{
    private $gui;

    public function __construct(\rikmeijer\Teach\GUI\SSO $gui)
    {
        $this->gui = $gui;
    }

    public function handleRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $queryParams = $request->getQueryParams();

        if (array_key_exists('oauth_token', $queryParams) === false) {
            return ErrorFactory::makeInstance(400);
        } elseif (array_key_exists('oauth_verifier', $queryParams) === false) {
            return ErrorFactory::makeInstance(400);
        } else {
            return $this->gui->authorizeTokenCredentials(
                $queryParams['oauth_token'],
                $queryParams['oauth_verifier']
            );
        }
    }
}
