<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Contactmoment;

class Process implements RouteEndPoint
{
    private $contactmoment;
    private $rating;
    private $explanation;

    public function __construct(Contactmoment $contactmoment, string $rating, string $explanation)
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