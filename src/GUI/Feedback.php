<?php


namespace rikmeijer\Teach\GUI;

use pulledbits\ActiveRecord\Schema;
use rikmeijer\Teach\Contactmoment;

final class Feedback
{
    private $schema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    public function retrieveContactmoment(string $contactmomentIdentifier) : Contactmoment
    {
        return Contactmoment::read($this->schema, $contactmomentIdentifier);
    }
}