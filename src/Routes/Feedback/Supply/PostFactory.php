<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class PostFactory implements RouteEndPoint
{
    private $contactmoment;
    private $rating;
    private $explanation;

    public function __construct(Record $contactmoment, string $rating, string $explanation)
    {
        $this->contactmoment = $contactmoment;
        $this->rating = $rating;
        $this->explanation = $explanation;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $this->contactmoment->rate($_SERVER['REMOTE_ADDR'], $this->rating, $this->explanation);
        return $psrResponse->withBody(stream_for('Dankje!'));
    }
}