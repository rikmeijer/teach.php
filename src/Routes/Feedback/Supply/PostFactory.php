<?php
/**
 * User: hameijer
 * Date: 22-9-17
 * Time: 9:17
 */

namespace rikmeijer\Teach\Routes\Feedback\Supply;


use Aura\Session\CsrfToken;
use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;

class PostFactory implements ResponseFactory
{
    private $csrf_token;
    private $schema;
    private $responseFactory;
    private $contactmomentIdentifier;
    private $parsedBody;

    public function __construct(CsrfToken $csrf_token, Schema $schema, \pulledbits\Response\Factory $responseFactory, array $parsedBody, string $contactmomentIdentifier)
    {
        $this->csrf_token = $csrf_token;
        $this->schema = $schema;
        $this->responseFactory = $responseFactory;
        $this->contactmomentIdentifier = $contactmomentIdentifier;
        $this->parsedBody = $parsedBody;
    }

    public function makeResponse(): ResponseInterface
    {
        if ($this->csrf_token->isValid($this->parsedBody['__csrf_value']) === false) {
            return $this->responseFactory->make403("This looks like a cross-site request forgery.");
        } else {
            $this->schema->executeProcedure('rate_contactmoment', [$this->contactmomentIdentifier, $_SERVER['REMOTE_ADDR'], $this->parsedBody['rating'], $this->parsedBody['explanation']]);
            return $this->responseFactory->make201('Dankje!');
        }
    }
}