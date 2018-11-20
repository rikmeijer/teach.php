<?php


namespace rikmeijer\Teach;


use pulledbits\ActiveRecord\Record;
use pulledbits\ActiveRecord\Schema;

class Contactmoment
{
    private $record;

    public function __construct(Record $record)
    {
        $this->record = $record;
    }

    public function retrieveRating() {
        $contactmomentratings = $this->record->fetchByFkRatingContactmoment();
        if (count($contactmomentratings) === 0) {
            return null;
        }
        $value = 0;
        foreach ($contactmomentratings as $contactmomentrating) {
            $value += $contactmomentrating->waarde;
        }
        return $value / count($contactmomentratings);
    }

    static function wrapAround(Record $record) {
        return new self($record);
    }

    static function readVandaag(Schema $schema, string $owner) : array {
        return array_map([__CLASS__, 'wrapAround'], $schema->read('contactmoment_vandaag', [], ["owner" => $owner]));
    }

    public function __get($name)
    {
        return $this->record->$name;
    }

}