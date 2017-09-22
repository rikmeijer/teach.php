<?php namespace rikmeijer\Teach\Routes\Feedback;

use Psr\Http\Message\ServerRequestInterface;
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

    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)/supply$#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getUri()->getPath(), $matches);
        $responseFactory = $this->resources->responseFactory();
        switch ($request->getMethod()) {
            case 'GET':
                $phpview = $this->resources->phpview('Feedback\\Supply');
                $query = $request->getQueryParams();
                $contactmoment = $this->resources->schema()->readFirst('contactmoment', [], ['id' => $matches['contactmomentIdentifier']]);
                $assets = ['star' => $this->resources->readAssetStar(), 'unstar' => $this->resources->readAssetUnstar()];
                return new GetFactory($contactmoment, $phpview, $responseFactory, $assets, $query);

            case 'POST':
                $csrf_token = $this->resources->session()->getCsrfToken();
                $schema = $this->resources->schema();
                return new PostFactory($csrf_token, $schema, $responseFactory, $request->getParsedBody(), $matches['contactmomentIdentifier']);

            default:
                return $responseFactory->make405('Method not allowed');
        }

    }

}