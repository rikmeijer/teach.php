<?php namespace rikmeijer\Teach\Routes\Contactmoment\Import;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\User;

class Process implements RouteEndPoint
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
        return $this->phpview->prepareAsResponse($psrResponse, [
            "numberImported" => $this->user->importCalendarEvents()
        ]);
    }
}