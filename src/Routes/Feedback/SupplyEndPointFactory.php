<?php namespace rikmeijer\Teach\Routes\Feedback;

use Lifo\IP\IP;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\GUI\Feedback;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\Routes\Feedback\Supply\Process;
use rikmeijer\Teach\Routes\Feedback\Supply\Form;

class SupplyEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $useCase;
    private $phpviewDirectory;

    public function __construct(Feedback $useCase, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->useCase = $useCase;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('feedback');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)/supply$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getURI()->getPath(), $matches);
        $contactmoment = $this->useCase->retrieveContactmoment($matches['contactmomentIdentifier']);
        if ($contactmoment->id === null) {
            return ErrorFactory::makeInstance('404');
        }

        switch ($request->getMethod()) {
            case 'GET':
                $query = $request->getQueryParams();

                $ipRating = $contactmoment->findRatingFromIP($_SERVER['REMOTE_ADDR']);

                $rating = null;
                $explanation = '';
                if ($ipRating->waarde !== null) {
                    $rating = $ipRating->waarde;
                    $explanation = $ipRating->inhoud !== null ? $ipRating->inhoud : '';
                }

                if (array_key_exists('rating', $query)) {
                    $rating = $query['rating'];
                }
                return new PHPviewEndPoint($this->phpviewDirectory->load('supply', ['rating' => $rating, 'explanation' => $explanation]));

            case 'POST':
                $parsedBody = $request->getParsedBody();
                if ($this->useCase->verifyCSRFToken($parsedBody['__csrf_value']) === false) {
                    return ErrorFactory::makeInstance('403');
                }
                $contactmoment->rate($_SERVER['REMOTE_ADDR'], $parsedBody['rating'], $parsedBody['explanation']);
                return new PHPviewEndPoint($this->phpviewDirectory->load('processed'));

            default:
                return ErrorFactory::makeInstance('405');
        }

    }

}