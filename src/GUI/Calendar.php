<?php

namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
use pulledbits\View\Directory;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPviewEndPoint;

final class Calendar implements GUI
{
    /**
     * @var Directory
     */
    private $phpview;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->phpview = $bootstrap->resource('phpview')->load('calendar');

        $calendarFactory = $bootstrap->resource('calendar');

        $this->phpview->registerHelper(
            'calendar',
            function (TemplateInstance $templateInstance, string $calendarIdentifier) use ($calendarFactory) : \Eluceo\iCal\Component\Calendar {
                return $calendarFactory($calendarIdentifier)->generate();
            }
        );
    }

    public function mapRoutes(Map $map): void
    {
        $map->get(
            'calendar',
            '/calendar/{calendarIdentifier}',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                $response = PHPviewEndPoint::attachToResponse(
                    $response,
                    $this->phpview->prepare(
                        ['calendarIdentifier' => $request->getAttribute(
                            'calendarIdentifier'
                        )]
                    )
                );
                return $response->withHeader('Content-Type', 'text/calendar; charset=utf-8')
                    ->withHeader(
                        'Content-Disposition',
                        'attachment; filename="' . $request->getAttribute('calendarIdentifier') . '.ics"'
                    );
            }
        );
    }
}
