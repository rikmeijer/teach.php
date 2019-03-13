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

    static function view(\rikmeijer\Teach\Bootstrap $bootstrap) : callable {
        $session = $bootstrap->session();
        $schema = $bootstrap->schema();
        $phpviewDirectory = $bootstrap->phpviewDirectoryFactory()->make('');
        $feedbackGUI = new self($session, $schema);

        return function(\Psr\Http\Message\ServerRequestInterface $request) use ($feedbackGUI, $phpviewDirectory): \pulledbits\Router\RouteEndPoint {
            $contactmoment = $feedbackGUI->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
            if ($contactmoment->id === null) {
                return \pulledbits\Router\ErrorFactory::makeInstance(404);
            }
            return new \rikmeijer\Teach\PHPviewEndPoint($phpviewDirectory->load('feedback', [
                'contactmoment' => $contactmoment
            ]));
        };
    }

    static function supply(\rikmeijer\Teach\Bootstrap $bootstrap) : callable {
        $session = $bootstrap->session();
        $schema = $bootstrap->schema();
        $phpviewDirectory = $bootstrap->phpviewDirectoryFactory()->make('feedback');

        $feedbackGUI = new self($session, $schema);

        return function(\Psr\Http\Message\ServerRequestInterface $request) use ($feedbackGUI, $phpviewDirectory): \pulledbits\Router\RouteEndPoint {
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
        };
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