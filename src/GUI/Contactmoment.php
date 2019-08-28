<?php

namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\Calendar;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\User;

class Contactmoment implements GUI
{

    /**
     * @var Calendar
     */
    private $rooster;

    /**
     * @var User
     */
    private $user;
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->rooster = $bootstrap->resource('rooster');
        $this->user = $bootstrap->resource('user');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function importRooster(): int
    {
        return $this->user->importEventsFromRooster($this->rooster);
    }

    public function mapRoutes(Map $map): void
    {
        $view = new Contactmoment\Import($this, $this->phpviewDirectory);
        $map->get('contactmoment.import', '/contactmoment/import', function (ServerRequestInterface $request, ResponseInterface $response) use ($view) : ResponseInterface {
            return PHPviewEndPoint::attachToResponse($response, $view->handleGet($request)->prepare());
        });
        $map->post('contactmoment.imported', '/contactmoment/import', function (ServerRequestInterface $request, ResponseInterface $response) use ($view) : ResponseInterface {
            return PHPviewEndPoint::attachToResponse($response, $view->handlePost($request)->prepare());
        });
    }
}
