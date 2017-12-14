<?php namespace rikmeijer\Teach\Routes\Contactmoment\Import;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;

class GetFactory implements RouteEndPoint
{
    private $phpview;

    public function __construct(\pulledbits\View\Directory $phpview)
    {
        $this->phpview = $phpview;
    }

    public function respond(\pulledbits\Response\Factory $psrResponseFactory): ResponseInterface
    {
        return $psrResponseFactory->make200($this->phpview->load('import')->prepare(['importForm' => function (): void {
            $model = 'ICS URL: <input type="text" name="url" />';
            $this->form("post", "Importeren", $model);
        }])->capture());
    }
}