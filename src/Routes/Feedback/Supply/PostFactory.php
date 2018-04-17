<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class PostFactory implements RouteEndPoint
{
    private $schema;
    private $contactmomentIdentifier;
    private $rating;
    private $explanation;

    public function __construct(Schema $schema, string $contactmomentIdentifier, string $rating, string $explanation)
    {
        $this->schema = $schema;
        $this->contactmomentIdentifier = $contactmomentIdentifier;
        $this->rating = $rating;
        $this->explanation = $explanation;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $this->schema->executeProcedure('rate_contactmoment', [$this->contactmomentIdentifier, $_SERVER['REMOTE_ADDR'], $this->rating, $this->explanation]);
        return $psrResponse->withBody(stream_for('Dankje!'));
    }
}