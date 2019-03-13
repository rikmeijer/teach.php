<?php


namespace rikmeijer\Teach\GUI;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPviewEndPoint;

class QR
{

    public static function view(\rikmeijer\Teach\Bootstrap $bootstrap)
    {
        $phpviewDirectory = $bootstrap->phpviewDirectoryFactory()->make('');
        return function(ServerRequestInterface $request) use ($phpviewDirectory): RouteEndPoint
        {
            $query = $request->getQueryParams();
            if (array_key_exists('data', $query) === false) {
                syslog(E_USER_ERROR, 'Query incomplete');
                return ErrorFactory::makeInstance('400');
            } elseif ($query['data'] === null) {
                syslog(E_USER_ERROR, 'Query data incomplete');
                return ErrorFactory::makeInstance('400');
            }
            return new PHPviewEndPoint($phpviewDirectory->load('qr', [
                'data' => $query['data'],
                'qr' => function (int $width, int $height, string $data): void {
                    $renderer = new \BaconQrCode\Renderer\Image\Png();
                    $renderer->setHeight($width);
                    $renderer->setWidth($height);
                    $writer = new \BaconQrCode\Writer($renderer);
                    print $writer->writeString($data);
                }
            ]));
        };
    }
}