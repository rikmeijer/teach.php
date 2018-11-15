<?php namespace rikmeijer\Teach\Routes\Rating;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Image implements RouteEndPoint
{
    private $phpview;
    private $ratingwaarde;
    private $assets;

    public function __construct(\pulledbits\View\Template $phpview, $ratingwaarde, array $assets)
    {
        $this->phpview = $phpview;
        $this->ratingwaarde = $ratingwaarde;
        $this->assets = $assets;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $im = imagecreatetruecolor(500, 100);
        imagealphablending($im, false);
        imagesavealpha($im, true);
        imagefilledrectangle($im, 0, 0, 500, imagesy($im), imagecolorallocatealpha($im, 255, 255, 255, 127));

        return $this->phpview->prepareAsResponse($psrResponse->withHeader('Content-Type', 'image/png'), [
            'im' => $im,
            'ratingwaarde' => $this->ratingwaarde,
            'star' => imagecreatefromstring($this->assets['star']),
            'unstar' => imagecreatefromstring($this->assets['unstar']),
            'nostar' => imagecreatefromstring($this->assets['nostar'])
        ]);
    }
}