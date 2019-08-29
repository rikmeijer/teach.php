<?php


namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\Beans\Contactmoment;
use rikmeijer\Teach\Daos\ContactmomentDao;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\GUI\Feedback\Supply;
use rikmeijer\Teach\GUI\Feedback\View;
use rikmeijer\Teach\PHPviewEndPoint;

final class Feedback implements GUI
{
    /**
     * @var CsrfToken
     */
    private $csrf;

    /**
     * @var ContactmomentDao
     */
    private $dao;

    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->csrf = $bootstrap->resource('csrf');
        $this->dao = $bootstrap->resource('dao')('Contactmoment');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
        $this->phpviewDirectory->registerHelper(
            'contactmomentRating',
            function (TemplateInstance $templateInstance, string $contactmomentIdentifier): float {
                return $this->retrieveContactmoment($contactmomentIdentifier)->getAverageRating();
            }
        );
    }

    public function retrieveContactmoment(string $contactmomentIdentifier): Contactmoment
    {
        return $this->dao->getById($contactmomentIdentifier);
    }

    public function verifyCSRFToken(string $CSRFToken): bool
    {
        return $this->csrf->isValid($CSRFToken);
    }

    public function retrieveRating(Request $request) {
        $contactmoment = $this->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
        if ($contactmoment->getId() === null) {
            return ErrorFactory::makeInstance('404');
        }

        return $contactmoment->findRatingByIP(($request->getServerParams())['REMOTE_ADDR']);
    }

    public function mapRoutes(Map $map): void
    {
        $map->get(
            'feedback.supply',
            '/feedback/{contactmomentIdentifier}/supply',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                $view = new Supply($this, $this->phpviewDirectory);
                return $view->handleGet($this->retrieveRating($request), $request->getQueryParams())->respond($response);
            }
        )->tokens(['contactmomentIdentifier' => '\d+']);

        $map->post(
            'feedback.supplied',
            '/feedback/{contactmomentIdentifier}/supply',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                $view = new Supply($this, $this->phpviewDirectory);
                return $view->handlePost($this->retrieveRating($request), $request->getParsedBody())->respond($response);
            }
        )->tokens(['contactmomentIdentifier' => '\d+']);

        $map->get(
            'feedback',
            '/feedback/{contactmomentIdentifier}',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                $this->phpviewDirectory->registerHelper(
                    'feedbackSupplyURL',
                    function (TemplateInstance $templateInstance, string $contactmomentIdentifier): string {
                        return $templateInstance->url('/feedback/%s/supply', $contactmomentIdentifier);
                    }
                );

                return (new PHPviewEndPoint(
                    $this->phpviewDirectory->load(
                        'feedback',
                        ['contactmomentIdentifier' => $request->getAttribute('contactmomentIdentifier')]
                    )
                ))->respond($response);
            }
        );
    }
}
