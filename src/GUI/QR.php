<?php


namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\Bootstrap;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPviewEndPoint;

class QR implements GUI
{
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->phpviewDirectory = $bootstrap->resource('phpview')->make('');
        $this->phpviewDirectory->registerHelper('qr', function(int $width, int $height, string $data): void {
            $renderer = new \BaconQrCode\Renderer\Image\Png();
            $renderer->setHeight($width);
            $renderer->setWidth($height);
            $writer = new \BaconQrCode\Writer($renderer);
            print $writer->writeString($data);
        });
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('^/qr', function() : Route {
            return new class($this->phpviewDirectory) implements Route {
                private $phpviewDirectory;

                public function __construct(Directory $phpviewDirectory)
                {
                    $this->phpviewDirectory = $phpviewDirectory;
                }

                public function handleRequest(ServerRequestInterface $request)  : RouteEndPoint {
                    $query = $request->getQueryParams();
                    if (array_key_exists('data', $query) === false) {
                        syslog(E_USER_ERROR, 'Query incomplete');
                        return ErrorFactory::makeInstance('400');
                    } elseif ($query['data'] === null) {
                        syslog(E_USER_ERROR, 'Query data incomplete');
                        return ErrorFactory::makeInstance('400');
                    }
                    return new PHPviewEndPoint($this->phpviewDirectory->load('qr', [
                        'data' => $query['data']
                    ]));
                }
            };
        });
    }
}