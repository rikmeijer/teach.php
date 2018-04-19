<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class GetFactory implements RouteEndPoint
{
    private $phpview;
    private $assets;
    private $rating;
    private $explanation;

    public function __construct(\pulledbits\View\Template $phpview, array $assets, string $rating, string $explanation)
    {
        $this->phpview = $phpview;
        $this->assets = $assets;
        $this->rating = $rating;
        $this->explanation = $explanation;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $assets = $this->assets;
        return $this->phpview->prepareAsResponse($psrResponse, ['rating' => $this->rating, 'explanation' => $this->explanation, 'star' => function (int $i, $rating) use ($assets) : string {
            $data = $assets['unstar'];
            if ($i < $rating) {
                $data = $assets['star'];
            }
            return 'data:image/png;base64,' . base64_encode($data);
        }]);
    }
}