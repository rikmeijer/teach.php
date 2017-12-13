<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;

class GetFactory implements ResponseFactory
{
    private $iprating;
    private $responseFactory;
    private $phpview;
    private $assets;
    private $query;

    public function __construct(Record $iprating, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, array $assets, array $query)
    {
        $this->iprating = $iprating;
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
        $this->assets = $assets;
        $this->query = $query;
    }

    public function makeResponse(): ResponseInterface
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
        return $this->responseFactory->make200($this->phpview->capture('supply', ['rating' => $rating, 'explanation' => $explanation, 'star' => function (int $i, $rating) use ($assets) : string {
            $data = $assets['unstar'];
            if ($i < $rating) {
                $data = $assets['star'];
            }
            return 'data:image/png;base64,' . base64_encode($data);
        }]));
    }
}