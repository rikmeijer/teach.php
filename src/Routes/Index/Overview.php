<?php namespace rikmeijer\Teach\Routes\Index;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\User;

class Overview implements RouteEndPoint
{
    private $user;
    private $phpview;

    public function __construct(User $user, \pulledbits\View\Template $phpview)
    {
        $this->user = $user;
        $this->phpview = $phpview;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $this->phpview->prepareAsResponse($psrResponse, [
            'modules' => $this->user->retrieveModules(),
            'contactmomenten' => $this->user->retrieveModulecontactmomentenToday()
        ]);
    }
}