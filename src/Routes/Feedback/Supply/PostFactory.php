<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;

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

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        $this->schema->executeProcedure('rate_contactmoment', [$this->contactmomentIdentifier, $_SERVER['REMOTE_ADDR'], $this->rating, $this->explanation]);
        return $psrResponseFactory->make('201', 'Dankje!');
    }
}