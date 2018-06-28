<?php namespace rikmeijer\Teach\Routes\User;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\User;

class Logout implements RouteEndPoint
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $this->user->logout();
        return $psrResponse->withStatus('303')->makeWithHeaders(['Location' => '/'], '');
    }
}