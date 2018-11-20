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

    static function wrapAround(Record $record) {
        return new self($record);
    }

    static function readByModuleName(Schema $schema, string $owner, string $moduleNaam) {
        return array_map([__CLASS__, 'wrapAround'], $schema->read("contactmoment_module", [], ["modulenaam" => $moduleNaam, "owner" => $owner]));
    }

    static function readVandaag(Schema $schema, string $owner) : array {
        return array_map([__CLASS__, 'wrapAround'], $schema->read('contactmoment_vandaag', [], ["owner" => $owner]));
    }

    static function read(Schema $schema, string $owner, string $identifier) {
        $contactmoments = $schema->read('contactmoment', [], ['id' => $identifier, "owner" => $owner]);
        if (count($contactmoments) === 0) {
            $contactmoments[0] = new class implements Record {

                public function contains(array $values)
                {}

                public function __get($property)
                {
                    return null;
                }

                public function __set($property, $value)
                {}

                public function delete(): int
                {
                    return 0;
                }

                public function create(): int
                {
                    return 0;
                }

                public function __call(string $method, array $arguments)
                {
                    return null;
                }

                public function bind(string $methodIdentifier, callable $callback): void
                {
                }
            };
        }
        return array_map([__CLASS__, 'wrapAround'], $contactmoments);
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


    public function findRatingFromIP(string $ipAddress) {
        $ipRatings = $this->fetchByFkRatingContactmoment(['ipv4' => $ipAddress]);
        if (count($ipRatings) > 0) {
            return $ipRatings[0];
        } else {
            return $this->referenceByFkRatingContactmoment(['ipv4' => $ipAddress]);
        }
    }

    public function rate(string $ipAddress, string $rating, string $explanation) {
        $this->entityType->call('rate_contactmoment', [$this->__get('id'), $ipAddress, $rating, $explanation]);
    }


    public function __get($name)
    {
        return $this->record->$name;
    }

}