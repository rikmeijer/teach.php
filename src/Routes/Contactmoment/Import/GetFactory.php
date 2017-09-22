<?php namespace rikmeijer\Teach\Routes\Contactmoment\Import;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;

class GetFactory implements ResponseFactory
{
    private $responseFactory;
    private $phpview;

    public function __construct(\pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
    }

    public function makeResponse(): ResponseInterface
    {
        return $this->responseFactory->make200($this->phpview->capture('import', ['importForm' => function (): void {
            $model = 'ICS URL: <input type="text" name="url" />';
            $this->form("post", "Importeren", $model);
        }]));
    }
}