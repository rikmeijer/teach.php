<?php namespace rikmeijer\Teach\Routes\Contactmoment\Import;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class GetFactory implements RouteEndPoint
{
    private $phpview;

    public function __construct(\pulledbits\View\Template $phpview)
    {
        $this->phpview = $phpview;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $this->phpview->prepareAsResponse($psrResponse, ['importForm' => function (): void {
            $model = 'rooster.avans.nl';
            $this->form("post", "Importeren", $model);
        }]);
    }
}