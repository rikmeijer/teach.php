<?php namespace rikmeijer\Teach\Routes\Feedback;

use Aura\Session\Session;
use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Feedback\Supply\PostFactory;
use rikmeijer\Teach\Routes\Feedback\Supply\GetFactory;

class SupplyFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $schema;
    private $filesystem;
    private $phpviewDirectory;
    private $session;

    public function __construct(Schema $schema, FilesystemInterface $filesystem, PHPViewDirectoryFactory $phpviewDirectoryFactory, Session $session)
    {
        $this->schema = $schema;
        $this->filesystem = $filesystem;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('feedback');
        $this->session = $session;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)/supply$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        preg_match('#^/feedback/(?<contactmomentIdentifier>\d+)#', $request->getURI()->getPath(), $matches);
        switch ($request->getMethod()) {
            case 'GET':
                $query = $request->getQueryParams();
                $contactmoments = $this->schema->read('contactmoment', [], ['id' => $matches['contactmomentIdentifier']]);
                if (count($contactmoments) === 0) {
                    return ErrorFactory::makeInstance('404');
                }
                $ipRatings = $contactmoments[0]->fetchByFkRatingContactmoment(['ipv4' => $_SERVER['REMOTE_ADDR']]);
                if (count($ipRatings) > 0) {
                    $ipRating = $ipRatings[0];
                } else {
                    $ipRating = $contactmoments[0]->referenceByFkRatingContactmoment(['ipv4' => $_SERVER['REMOTE_ADDR']]);
                }

                $assets = [
                    'star' => $this->filesystem->read(DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'star.png'),
                    'unstar' => $this->filesystem->read(DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'unstar.png')
                ];
                return new GetFactory($ipRating, $this->phpviewDirectory->load('supply'), $assets, $query);

            case 'POST':
                $csrf_token = $this->session->getCsrfToken();
                $parsedBody = $request->getParsedBody();
                if ($csrf_token->isValid($parsedBody['__csrf_value']) === false) {
                    return ErrorFactory::makeInstance('403');
                }
                return new PostFactory($this->schema, $matches['contactmomentIdentifier'], $parsedBody['rating'], $parsedBody['explanation']);

            default:
                return ErrorFactory::makeInstance('405');
        }

    }

}