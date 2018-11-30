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

    public function __construct(SSO $server, Session $session, Schema $schema)
    {
        $this->session = $session;
        $this->schema = $schema;
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
            $modulecontactmomenten = Contactmoment::readByModuleName($this->schema, $this->details()->uid, $module->naam);

            if (count($modulecontactmomenten) > 0) {
                $module->contains(['contactmomenten' => $modulecontactmomenten]);
                $module->bind('retrieveRating', function ()
                {
                    $ratings = [];
                    foreach ($this->contactmomenten as $modulecontactmoment) {
                        $ratings[] = $modulecontactmoment->retrieveRating();
                    }
                    $numericRatings = array_filter($ratings, 'is_numeric');
                    if (count($numericRatings) === 0) {
                        return null;
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
        return Contactmoment::readVandaag($this->schema, $this->details()->uid);
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

    public function retrieveContactmoment($contactmomentIdentifier) : Contactmoment
    {
        return Contactmoment::read($this->schema, $contactmomentIdentifier);
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

    public function verifyCSRFToken(string $CSRFToken) : bool
    {
        return $this->session->getCsrfToken()->isValid($CSRFToken);
    }
}