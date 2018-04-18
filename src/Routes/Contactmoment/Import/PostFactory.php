<?php namespace rikmeijer\Teach\Routes\Contactmoment\Import;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\User;

class PostFactory implements RouteEndPoint
{
    private $phpview;
    private $user;

    public function __construct(\pulledbits\View\Template $phpview, User $user)
    {
        $this->phpview = $phpview;
        $this->user = $user;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $this->user->importCalendarEvents();
        return $this->phpview->prepareAsResponse($psrResponse, []);
    }
}