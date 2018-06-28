<?php namespace rikmeijer\Teach\Routes\Qr;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Code implements RouteEndPoint
{
    private $phpview;
    private $data;

    public function __construct(\pulledbits\View\Template $phpview, string $data)
    {
        $this->phpview = $phpview;
        $this->data = $data;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $this->phpview->registerHelper('qr', function (int $width, int $height, string $data): void {
            $renderer = new \BaconQrCode\Renderer\Image\Png();
            $renderer->setHeight($width);
            $renderer->setWidth($height);
            $writer = new \BaconQrCode\Writer($renderer);
            print $writer->writeString($data);
        });

        return $this->phpview->prepareAsResponse($psrResponse, ['data' => $this->data]);
    }
}