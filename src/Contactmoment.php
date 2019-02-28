<?php


namespace rikmeijer\Teach;


use pulledbits\ActiveRecord\Entity;
use pulledbits\ActiveRecord\Schema;

final class Contactmoment
{
    private $record;

    public function __construct(Entity $entity)
    {
        $this->record = $entity;
    }

    static function wrapAround(Entity $entity) : self {
        return new self($entity);
    }

    static function readByModuleName(Schema $schema, string $owner, string $moduleNaam) : array {
        return array_map([__CLASS__, 'wrapAround'], $schema->read("contactmoment_module", [], ["modulenaam" => $moduleNaam, "owner" => $owner]));
    }

    static function readVandaag(Schema $schema, string $owner) : array {
        return array_map([__CLASS__, 'wrapAround'], $schema->read('contactmoment_vandaag', [], ["owner" => $owner]));
    }

    static function read(Schema $schema, string $identifier) : self {
        $contactmoments = $schema->read('contactmoment', [], ['id' => $identifier]);
        if (count($contactmoments) === 0) {
            $contactmoments[0] = new class implements Entity {

                final public function contains(array $values) : void
                {}

                final public function __get($property)
                {
                    return null;
                }

                final public function __set($property, $value)
                {}

                final public function __isset($property)
                {}

                final public function delete(): int
                {
                    return 0;
                }

                final public function create(): int
                {
                    return 0;
                }

                final public function __call(string $method, array $arguments)
                {
                    return null;
                }

                final public function bind(string $methodIdentifier, callable $callback): void
                {
                }
            };
        }
        return array_map([__CLASS__, 'wrapAround'], $contactmoments)[0];
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
        $ipRatings = $this->record->fetchByFkRatingContactmoment(['ip' => $ipAddress]);
        if (count($ipRatings) === 0) {
            return $this->record->referenceByFkRatingContactmoment(['ip' => $ipAddress]);
        }
        return $ipRatings[0];
    }

    public function rate(string $ipAddress, string $rating, string $explanation) {
        $this->record->rate_contactmoment($this->record->id, $ipAddress, $rating, $explanation);
    }


    public function __get(string $name)
    {
        $value = $this->record->$name;
        switch ($name) {
            case 'starttijd':
            case 'eindtijd':
                try {
                    return new \DateTime($value);
                } catch (\Exception $e) {
                    return $value;
                }

            case 'active':
                return strtotime($this->record->starttijd) <= time() && strtotime($this->record->starttijd) >= time();
            case 'past':
                return strtotime($this->record->eindtijd) <= time();

            default:
                return $value;
        }
    }

    public function __set(string $name, $value)
    {
        $this->record->$name = $value;
    }

    public function __isset(string $name)
    {
        return isset($this->record->$name);
    }
}