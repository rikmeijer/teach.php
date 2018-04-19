<?php namespace rikmeijer\Teach\Routes\Feedback;

use Aura\Session\Session;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Feedback\Supply\PostFactory;
use rikmeijer\Teach\Routes\Feedback\Supply\GetFactory;
use rikmeijer\Teach\User;

class SupplyFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $user;
    private $schema;
    private $phpviewDirectory;

    public function __construct(User $user, Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->user = $user;
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('feedback');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)/supply$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getURI()->getPath(), $matches);
        $contactmoment = $this->user->retrieveContactmoment($matches['contactmomentIdentifier']);
        if ($contactmoment->id !== $matches['contactmomentIdentifier']) {
            return ErrorFactory::makeInstance('404');
        }

        switch ($request->getMethod()) {
            case 'GET':
                $query = $request->getQueryParams();

                $ipRating = $contactmoment->findRatingFromIP($_SERVER['REMOTE_ADDR']);
                $assets = [
                    'star' =>  $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'star.png'),
                    'unstar' => $this->user->readPublicAsset('img' . DIRECTORY_SEPARATOR . 'unstar.png')
                ];
                return new GetFactory($ipRating, $this->phpviewDirectory->load('supply'), $assets, $query);

            case 'POST':
                $parsedBody = $request->getParsedBody();
                if ($this->user->verifyCSRFToken($parsedBody['__csrf_value']) === false) {
                    return ErrorFactory::makeInstance('403');
                }
                return new PostFactory($contactmoment, $parsedBody['rating'], $parsedBody['explanation']);

            default:
                return ErrorFactory::makeInstance('405');
        }

    }

}