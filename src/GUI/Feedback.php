<?php


namespace rikmeijer\Teach\GUI;

use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\Beans\Contactmoment;
use rikmeijer\Teach\Daos\ContactmomentDao;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\GUI\Feedback\Supply;
use rikmeijer\Teach\GUI\Feedback\View;

final class Feedback implements GUI
{
    private $session;

    /**
     * @var ContactmomentDao
     */
    private $dao;

    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $this->session = $bootstrap->resource('session');
        $this->dao = $bootstrap->resource('dao')('Contactmoment');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
        $this->phpviewDirectory->registerHelper('contactmomentRating', function(TemplateInstance $templateInstance, string $contactmomentIdentifier) : float {
            return $this->retrieveContactmoment($contactmomentIdentifier)->getAverageRating();
        });
    }

    public function verifyCSRFToken(string $CSRFToken): bool
    {
        return $this->session->getCsrfToken()->isValid($CSRFToken);
    }

    public function retrieveContactmoment(string $contactmomentIdentifier): Contactmoment
    {
        return $this->dao->getById($contactmomentIdentifier);
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('/feedback/(?<contactmomentIdentifier>\d+)/supply$', new Supply($this, $this->phpviewDirectory));
        $router->addRoute('/feedback/(?<contactmomentIdentifier>\d+)', new View($this->phpviewDirectory));
    }
}
