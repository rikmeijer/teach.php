<?php

namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\View\Directory;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPviewEndPoint;

final class Calendar implements GUI
{
    private $schema;
    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $bootstrap->resource('calendar');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('/calendar/(?<calendarIdentifier>[^/]+)', function (ServerRequestInterface $request, callable $next): ResponseInterface {
            $phpview = new PHPviewEndPoint(
                $this->phpviewDirectory->load('calendar', ['calendarIdentifier' => $request->getAttribute('calendarIdentifier')])
            );
            return $phpview->respond($next($request))
                ->withHeader('Content-Type', 'text/calendar; charset=utf-8')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $request->getAttribute('calendarIdentifier') . '.ics"');
        });
    }
}
