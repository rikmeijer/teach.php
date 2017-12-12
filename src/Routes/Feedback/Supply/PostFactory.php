<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;

class PostFactory implements ResponseFactory
{
    private $schema;
    private $responseFactory;
    private $contactmomentIdentifier;
    private $rating;
    private $explanation;

    public function __construct(Schema $schema, \pulledbits\Response\Factory $responseFactory, string $contactmomentIdentifier, string $rating, string $explanation)
    {
        $this->schema = $schema;
        $this->responseFactory = $responseFactory;
        $this->contactmomentIdentifier = $contactmomentIdentifier;
        $this->rating = $rating;
        $this->explanation = $explanation;
    }

    public function makeResponse(): ResponseInterface
    {
        $this->schema->executeProcedure('rate_contactmoment', [$this->contactmomentIdentifier, $_SERVER['REMOTE_ADDR'], $this->rating, $this->explanation]);
        return $this->responseFactory->make201('Dankje!');
    }
}