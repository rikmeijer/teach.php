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
    private $phpviewDirectory;

    public function __construct(User $user, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->user = $user;
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

                $rating = null;
                $explanation = '';
                if ($this->iprating->waarde !== null) {
                    $rating = $this->iprating->waarde;
                    $explanation = $this->iprating->inhoud !== null ? $this->iprating->inhoud : '';
                }

                if (array_key_exists('rating', $query)) {
                    $rating = $query['rating'];
                }
                return new GetFactory($ipRating, $this->phpviewDirectory->load('supply'), $assets, $rating, $explanation);

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