<?php
/**
 * User: hameijer
 * Date: 22-9-17
 * Time: 9:15
 */

namespace rikmeijer\Teach\Routes\Feedback\Supply;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;

class GetFactory implements ResponseFactory
{
    private $contactmoment;
    private $responseFactory;
    private $phpview;
    private $assets;
    private $query;

    public function __construct(Record $contactmoment, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, array $assets, array $query)
    {
        $this->contactmoment = $contactmoment;
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
        $this->assets = $assets;
        $this->query = $query;
    }

    public function makeResponse(): ResponseInterface
    {

        $ipRating = $this->contactmoment->fetchFirstByFkRatingContactmoment(['ipv4' => $_SERVER['REMOTE_ADDR']]);

        $rating = null;
        $explanation = '';
        if ($ipRating->waarde !== null) {
            $data = ['rating' => $ipRating->waarde, 'explanation' => $ipRating->inhoud];
            $rating = $data['rating'];
            $explanation = $data['explanation'] !== null ? $data['explanation'] : '';
        }

        if (array_key_exists('rating', $this->query)) {
            $rating = $this->query['rating'];
        }

        $assets = $this->assets;
        return $this->responseFactory->make200($this->phpview->capture('supply', ['rating' => $rating, 'explanation' => $explanation, 'contactmomentIdentifier' => $this->contactmoment->id, 'star' => function (int $i, $rating) use ($assets) : string {
            $data = $assets['unstar'];
            if ($i < $rating) {
                $data = $assets['star'];
            }
            return 'data:image/png;base64,' . base64_encode($data);
        }]));
    }
}