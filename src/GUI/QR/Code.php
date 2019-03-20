<?php


namespace rikmeijer\Teach\GUI\QR;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;

class Code implements Route
{
    private $phpviewDirectory;

    public function __construct(Directory $phpviewDirectory)
    {
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $query = $request->getQueryParams();
        if (array_key_exists('data', $query) === false) {
            syslog(E_USER_ERROR, 'Query incomplete');
            return ErrorFactory::makeInstance('400');
        } elseif ($query['data'] === null) {
            syslog(E_USER_ERROR, 'Query data incomplete');
            return ErrorFactory::makeInstance('400');
        }
        return new PHPviewEndPoint($this->phpviewDirectory->load('qr', ['data' => $query['data']]));
    }
}
