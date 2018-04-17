<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class GetFactory implements RouteEndPoint
{
    private $iprating;
    private $phpview;
    private $assets;
    private $query;

    public function __construct(Record $iprating, \pulledbits\View\Template $phpview, array $assets, array $query)
    {
        $this->iprating = $iprating;
        $this->phpview = $phpview;
        $this->assets = $assets;
        $this->query = $query;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $rating = null;
        $explanation = '';
        if ($this->iprating->waarde !== null) {
            $rating = $this->iprating->waarde;
            $explanation = $this->iprating->inhoud !== null ? $this->iprating->inhoud : '';
        }

        if (array_key_exists('rating', $this->query)) {
            $rating = $this->query['rating'];
        }

        $assets = $this->assets;
        return $this->phpview->prepareAsResponse($psrResponse, ['rating' => $rating, 'explanation' => $explanation, 'star' => function (int $i, $rating) use ($assets) : string {
            $data = $assets['unstar'];
            if ($i < $rating) {
                $data = $assets['star'];
            }
            return 'data:image/png;base64,' . base64_encode($data);
        }]);
    }
}