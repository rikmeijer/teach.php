<?php


namespace rikmeijer\Teach\GUI;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\Router;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;

class QR
{
    private $phpviewDirectory;

    public function __construct(PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
        $this->phpviewDirectory->registerHelper('qr', λize($this, 'generate'));
    }

    public function generate(int $width, int $height, string $data): void {
        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setHeight($width);
        $renderer->setWidth($height);
        $writer = new \BaconQrCode\Writer($renderer);
        print $writer->writeString($data);
    }

    public function makeRoute() : Route {
        return new class($this->phpviewDirectory) implements Route {
            private $phpviewDirectory;

            public function __construct(\rikmeijer\Teach\GUI\QR $gui, Directory $phpviewDirectory)
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
    }
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap, Router $router) : void {
    $qrGUI = new QR($bootstrap->resource('phpview'));
    $router->addRoute('^/qr', λize($qrGUI, 'makeRoute'));
};