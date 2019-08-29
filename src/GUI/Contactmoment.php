<?php

namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\Calendar\Weeks;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPviewEndPoint;

class Contactmoment implements GUI
{

    /**
     * @var Weeks
     */
    private $rooster;

    /**
     * @var \rikmeijer\Teach\Beans\User
     */
    private $user;
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->rooster = $bootstrap->resource('rooster');
        $this->user = $bootstrap->resource('user');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function mapRoutes(Map $map): void
    {
        $map->get(
            'contactmoment.import',
            '/contactmoment/import',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                return PHPviewEndPoint::attachToResponse($response, $this->phpviewDirectory->load(
                    'contactmoment/import',
                    [
                        'importForm' => function (TemplateInstance $templateInstance): void {
                            $templateInstance->form("post", "Importeren", 'rooster.avans.nl');
                        }
                    ]
                )->prepare());
            }
        );
        $map->post(
            'contactmoment.imported',
            '/contactmoment/import',
            function (ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface {
                return PHPviewEndPoint::attachToResponse($response, $this->phpviewDirectory->load(
                    'contactmoment/imported',
                    ["numberImported" => $this->user->importEventsFromRooster($this->rooster)]
                )->prepare());
            }
        );
    }
}
