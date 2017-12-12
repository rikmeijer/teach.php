<?php namespace rikmeijer\Teach\Routes\Feedback;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\Routes\Feedback\Supply\PostFactory;
use rikmeijer\Teach\Routes\Feedback\Supply\GetFactory;

class SupplyFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)/supply$#', $uri->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getURI()->getPath(), $matches);
        $responseFactory = $this->resources->responseFactory();
        switch ($request->getMethod()) {
            case 'GET':
                $phpview = $this->resources->phpview('Feedback\\Supply');
                $query = $request->getQueryParams();
                $contactmoments = $this->resources->schema()->read('contactmoment', [], ['id' => $matches['contactmomentIdentifier']]);
                if (count($contactmoments) === 0) {
                    return ErrorFactory::makeInstance(404);
                }

                $assets = ['star' => $this->resources->readAssetStar(), 'unstar' => $this->resources->readAssetUnstar()];
                return new GetFactory($contactmoments[0], $phpview, $responseFactory, $assets, $query);

            case 'POST':
                $csrf_token = $this->resources->session()->getCsrfToken();
                $parsedBody = $request->getParsedBody();
                if ($csrf_token->isValid($parsedBody['__csrf_value']) === false) {
                    return ErrorFactory::makeInstance('403');
                }
                $schema = $this->resources->schema();
                return new PostFactory($schema, $responseFactory, $matches['contactmomentIdentifier'], $parsedBody['rating'], $parsedBody['explanation']);

            default:
                return ErrorFactory::makeInstance('405');
        }

    }

}