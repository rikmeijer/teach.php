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

    public static function wrapAroundEntity(Entity $entity): self
    {
        return new self($entity);
    }

    public static function wrapAroundEntities(array $entities): array
    {
        return array_map([__CLASS__, 'wrapAroundEntity'], $entities);
    }

    public static function read(Schema $schema, string $identifier): self
    {
        $contactmoments = $schema->read('contactmoment', [], ['id' => $identifier]);
        if (count($contactmoments) === 0) {
            $contactmoments[0] = new class implements Entity
            {

                final public function contains(array $values): void
                {
                }

                final public function __get($property)
                {
                    return null;
                }

                final public function __set($property, $value)
                {
                }

                final public function __isset($property)
                {
                }

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
        return self::wrapAroundEntities($contactmoments)[0];
    }

    public function rate(string $ipAddress, string $rating, string $explanation)
    {
        $this->record->rate_contactmoment($this->record->id, $ipAddress, $rating, $explanation);
    }


    private function convertToDateTime(string $date): \DateTime
    {
        try {
            return new \DateTime($date);
        } catch (\Exception $e) {
            return $date;
        }
    }

    public function __get(string $name)
    {
        $value = $this->record->$name;
        switch ($name) {
            case 'starttijd':
                return $this->convertToDateTime($value);
            case 'eindtijd':
                return $this->convertToDateTime($value);

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
