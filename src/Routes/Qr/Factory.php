<?php namespace rikmeijer\Teach\Routes\Qr;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Factory implements RouteEndPoint
{
    private $phpview;
    private $data;

    public function __construct(\pulledbits\View\Template $phpview, string $data)
    {
        $this->phpview = $phpview;
        $this->data = $data;
    }

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        $this->phpview->registerHelper('qr', function (int $width, int $height, string $data): void {
            $renderer = new \BaconQrCode\Renderer\Image\Png();
            $renderer->setHeight($width);
            $renderer->setWidth($height);
            $writer = new \BaconQrCode\Writer($renderer);
            print $writer->writeString($data);
        });

        return $psrResponseFactory->makeWithTemplate($this->phpview->prepare(['data' => $this->data]));
    }
}