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
    /**
     * @var CsrfToken
     */
    private $csrf;

    /**
     * @var ContactmomentDao
     */
    private $dao;

    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $this->csrf = $bootstrap->resource('csrf');
        $this->dao = $bootstrap->resource('dao')('Contactmoment');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
        $this->phpviewDirectory->registerHelper('contactmomentRating', function(TemplateInstance $templateInstance, string $contactmomentIdentifier) : float {
            return $this->retrieveContactmoment($contactmomentIdentifier)->getAverageRating();
        });
    }

    public function verifyCSRFToken(string $CSRFToken): bool
    {
        return $this->csrf->isValid($CSRFToken);
    }

    public function retrieveContactmoment(string $contactmomentIdentifier): Contactmoment
    {
        return $this->dao->getById($contactmomentIdentifier);
    }

    public function createRoutes() : array
    {
        return [
            '/feedback/(?<contactmomentIdentifier>\d+)/supply$' => new Supply($this, $this->phpviewDirectory),
            '/feedback/(?<contactmomentIdentifier>\d+)' => new View($this->phpviewDirectory)
        ];
    }
}
