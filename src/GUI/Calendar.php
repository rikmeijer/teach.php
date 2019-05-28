<?php

namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\View\Directory;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPviewEndPoint;

final class Calendar implements GUI
{
    /**
     * @var Directory
     */
    private $phpview;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $this->phpview = $bootstrap->resource('phpview')->load('calendar');

        $calendar = $bootstrap->resource('calendar');

        $this->phpview->registerHelper(
            'calendar', function (\pulledbits\View\TemplateInstance $templateInstance, string $calendarIdentifier) use ($calendar) : \Eluceo\iCal\Component\Calendar {
                return $calendar->generate($calendarIdentifier);
            }
        );
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute(
            '/calendar/(?<calendarIdentifier>[^/]+)',
            function (ServerRequestInterface $request, callable $next): ResponseInterface {
                $response = PHPviewEndPoint::attachToResponse(
                    $next($request),
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
