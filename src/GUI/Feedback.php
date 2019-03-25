<?php


namespace rikmeijer\Teach\GUI;

use phpDocumentor\Reflection\Types\Boolean;
use pulledbits\View\TemplateInstance;
use rikmeijer\Teach\Contactmoment;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\GUI\Feedback\Supply;
use rikmeijer\Teach\GUI\Feedback\View;

final class Feedback implements GUI
{
    private $session;
    private $schema;
    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $this->session = $bootstrap->resource('session');
        $this->schema = $bootstrap->resource('database');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
        $this->phpviewDirectory->registerHelper('contactmomentRating', function(TemplateInstance $templateInstance, string $contactmomentIdentifier) : int {
            $contactmoment = Contactmoment::read($templateInstance->resource('database'), $contactmomentIdentifier);
            return $contactmoment->retrieveRating();
        });
    }

    public function verifyCSRFToken(string $CSRFToken): bool
    {
        return $this->session->getCsrfToken()->isValid($CSRFToken);
    }

    public function retrieveContactmoment(string $contactmomentIdentifier): Contactmoment
    {
        return Contactmoment::read($this->schema, $contactmomentIdentifier);
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('/feedback/(?<contactmomentIdentifier>\d+)/supply$', new Supply($this, $this->phpviewDirectory));
        $router->addRoute('/feedback/(?<contactmomentIdentifier>\d+)', new View($this->phpviewDirectory));
    }
}
