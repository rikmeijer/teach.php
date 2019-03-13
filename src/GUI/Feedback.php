<?php


namespace rikmeijer\Teach\GUI;

use Aura\Session\Session;
use pulledbits\ActiveRecord\Schema;
use rikmeijer\Teach\Contactmoment;

final class Feedback
{
    private $session;
    private $schema;

    public function __construct(Session $session, Schema $schema)
    {
        $this->session = $session;
        $this->schema = $schema;
    }

    public function verifyCSRFToken(string $CSRFToken) : bool
    {
        return $this->session->getCsrfToken()->isValid($CSRFToken);
    }

    public function retrieveContactmoment(string $contactmomentIdentifier) : Contactmoment
    {
        return Contactmoment::read($this->schema, $contactmomentIdentifier);
    }
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap) : void {
    $session = $bootstrap->session();
    $schema = $bootstrap->schema();
    $phpviewDirectoryFactory = $bootstrap->phpviewDirectoryFactory();

    $bootstrap->router()->addRoute('^/feedback/(?<contactmomentIdentifier>\d+)/supply$', function(\Psr\Http\Message\ServerRequestInterface $request) use ($session, $schema, $phpviewDirectoryFactory): \pulledbits\Router\RouteEndPoint {

        $feedbackGUI = new Feedback($session, $schema);
        $phpviewDirectory = $phpviewDirectoryFactory->make('feedback');

        $contactmoment = $feedbackGUI->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
        if ($contactmoment->id === null) {
            return \pulledbits\Router\ErrorFactory::makeInstance('404');
        }

        switch ($request->getMethod()) {
            case 'GET':
                $ipRating = $contactmoment->findRatingByIP(($request->getServerParams())['REMOTE_ADDR']);

                $query = $request->getQueryParams();
                if (array_key_exists('rating', $query)) {
                    $rating = $query['rating'];
                } else {
                    $rating = $ipRating->waarde;
                }

                return new \rikmeijer\Teach\PHPviewEndPoint($phpviewDirectory->load('supply', ['rating' => $rating, 'explanation' => $ipRating->inhoud]));

            case 'POST':
                $parsedBody = $request->getParsedBody();
                if ($feedbackGUI->verifyCSRFToken($parsedBody['__csrf_value']) === false) {
                    return ErrorFactory::makeInstance('403');
                }
                $contactmoment->rate($_SERVER['REMOTE_ADDR'], $parsedBody['rating'], $parsedBody['explanation']);
                return new \rikmeijer\Teach\PHPviewEndPoint($phpviewDirectory->load('processed'));

            default:
                return \pulledbits\Router\ErrorFactory::makeInstance('405');
        }
    });
    $bootstrap->router()->addRoute('^/feedback/(?<contactmomentIdentifier>\d+)', function(\Psr\Http\Message\ServerRequestInterface $request) use ($session, $schema, $phpviewDirectoryFactory): \pulledbits\Router\RouteEndPoint {
        $feedbackGUI = new Feedback($session, $schema);
        $phpviewDirectory = $phpviewDirectoryFactory->make('');

        $contactmoment = $feedbackGUI->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
        if ($contactmoment->id === null) {
            return \pulledbits\Router\ErrorFactory::makeInstance(404);
        }
        return new \rikmeijer\Teach\PHPviewEndPoint($phpviewDirectory->load('feedback', [
            'contactmoment' => $contactmoment
        ]));
    });
};