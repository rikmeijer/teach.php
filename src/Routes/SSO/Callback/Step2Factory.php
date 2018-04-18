<?php namespace rikmeijer\Teach\Routes\SSO\Callback;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\User;

class Step2Factory implements RouteEndPoint
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $this->user->acquireTemporaryCredentials();
        exit;
    }
}