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