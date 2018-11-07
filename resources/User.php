<?php

namespace rikmeijer\Teach;

use Aura\Session\Session;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use pulledbits\ActiveRecord\Record;
use pulledbits\ActiveRecord\Schema;

class User
{
    private $server;
    private $schema;
    private $publicAssetsFileSystem;

    public function __construct(SSO $server, Session $session, Schema $schema, \League\Flysystem\FilesystemInterface $publicAssetsFileSystem)
    {
        $this->session = $session;
        $this->schema = $schema;
        $this->publicAssetsFileSystem = $publicAssetsFileSystem;
        $this->server = $server;
    }

    private function details(): \League\OAuth1\Client\Server\User
    {
        return $this->server->getUserDetails();
    }

    private function isEmployee()
    {
        return $this->details()->extra['employee'];
    }

    public function retrieveModules() : array
    {
        $modules = [];
        foreach ($this->schema->read('module', [], []) as $module) {
            $modulecontactmomenten = $this->schema->read("contactmoment_module", [], ["modulenaam" => $module->naam, "owner" => $this->details()->uid]);
            if (count($modulecontactmomenten) > 0) {
                $module->contains(['contactmomenten' => $modulecontactmomenten]);

                $user = $this;
                $module->bind('retrieveRating', function () use ($user, $modulecontactmomenten)
                {
                    $ratings = [];
                    foreach ($modulecontactmomenten as $modulecontactmoment) {
                        $ratings[] = $user->retrieveContactmoment($modulecontactmoment->id)->retrieveRating();
                    }
                    $numericRatings = array_filter($ratings, 'is_numeric');
                    if (count($numericRatings) === 0) {
                        return 0;
                    }
                    return array_sum($numericRatings) / count($numericRatings);
                });

                $modules[] = $module;
            }
        }
        return $modules;
    }

    public function retrieveModulecontactmomentenToday()
    {
        return $this->schema->read('contactmoment_vandaag', [], ["owner" => $this->details()->uid]);
    }

    public function retrieveCalendar(string $calendarIdentifier) : Calendar {
        $calendar = new Calendar($calendarIdentifier);
        switch ($calendarIdentifier) {
            case 'weeks':
                $lesweken = $this->schema->read('lesweek', [], []);
                foreach ($lesweken as $lesweek) {
                    $lesweekEvent = new Event();
                    $lesweekEvent->setNoTime(true);
                    $week_start = new \DateTime();
                    $week_start->setISODate($lesweek->jaar, $lesweek->kalenderweek);
                    $lesweekEvent->setUniqueId(sha1($lesweek->jaar . $lesweek->kalenderweek));
                    $lesweekEvent->setDtStart($week_start);
                    $lesweekEvent->setDtEnd($week_start);
                    $lesweekEvent->setSummary('OW' .  $lesweek->onderwijsweek . '/BW' . $lesweek->blokweek);
                    $calendar->addComponent($lesweekEvent);
                }
                break;

            default:
                error_log('Unknown calendar ' . $calendarIdentifier . ' requested');
                break;
        }
        return $calendar;
    }

    public function retrieveContactmoment($contactmomentIdentifier) : Record
    {
        $contactmoments = $this->schema->read('contactmoment', [], ['id' => $contactmomentIdentifier, "owner" => $this->details()->uid]);
        if (count($contactmoments) === 0) {
            return new class implements Record {

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

        $contactmoments[0]->bind('findRatingFromIP', function(string $ipAddress) {
            $ipRatings = $this->fetchByFkRatingContactmoment(['ipv4' => $ipAddress]);
            if (count($ipRatings) > 0) {
                return $ipRatings[0];
            } else {
                return $this->referenceByFkRatingContactmoment(['ipv4' => $ipAddress]);
            }
        });

        $contactmoments[0]->bind('retrieveRating', function ()
        {
            $contactmomentratings = $this->fetchByFkRatingContactmoment();
            if (count($contactmomentratings) === 0) {
                return null;
            }
            $value = 0;
            foreach ($contactmomentratings as $contactmomentrating) {
                $value += $contactmomentrating->waarde;
            }
            return $value / count($contactmomentratings);
        });


        $contactmoments[0]->bind('rate', function(string $ipAddress, string $rating, string $explanation) {
            $this->entityType->call('rate_contactmoment', [$this->__get('id'), $ipAddress, $rating, $explanation]);
        });

        return $contactmoments[0];
    }

    public function importCalendarEvents() : int
    {
        if ($this->isEmployee() === false) {
            return 0;
        }

        $userId = $this->details()->uid;
        $icalReader = new \ICal('http://rooster.avans.nl/gcal/D' . $this->details()->uid);
        $count = 0;
        foreach ($icalReader->events() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            } elseif (array_key_exists('LOCATION', $event) === false) {
                continue;
            }
            $this->schema->executeProcedure('import_ical_to_contactmoment', [$userId, $event['SUMMARY'], $event['UID'], $this->convertToSQLDateTime($event['DTSTART']), $this->convertToSQLDateTime($event['DTEND']), $event['LOCATION']]);
            $count++;
        }
        $this->schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);

        return $count;
    }

    private function convertToSQLDateTime(string $datetime): string
    {
        $datetime = new \DateTime($datetime);
        $datetime->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
        return $datetime->format('Y-m-d H:i:s');
    }

    public function logout() : void
    {
        if ($this->session->isStarted()) {
            $this->session->getSegment('token')->clear();
            $this->session->clear();
            $this->session->destroy();
        }
    }

    public function readPublicAsset(string $path)
    {
        return $this->publicAssetsFileSystem->read($path);
    }

    public function verifyCSRFToken(string $CSRFToken) : bool
    {
        return $this->session->getCsrfToken()->isValid($CSRFToken);
    }

}