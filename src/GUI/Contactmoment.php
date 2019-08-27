<?php

namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\Calendar;
use rikmeijer\Teach\GUI;
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
        $endpoint = function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
            $view = new Contactmoment\Import($this, $this->phpviewDirectory);
            return $view->handleRequest($request)->respond($response);
        };


        $map->get('contactmoment.import', '/contactmoment/import', $endpoint);
        $map->post('contactmoment.imported', '/contactmoment/import', $endpoint);
    }
}
