<?php
namespace rikmeijer\Teach;

use Aura\Session\Session;
use pulledbits\ActiveRecord\Schema;

final class User
{
    private $session;
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

    public function importCalendarEvents() : int
    {
        $details = $this->details();

        if ($details->extra['employee'] === false) {
            return 0;
        }

        $userId = $details->uid;
        $icalReader = new \ICal('http://rooster.avans.nl/gcal/D' . $userId);
        $count = 0;
        foreach ($icalReader->events() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            }
            if (array_key_exists('LOCATION', $event) === false) {
                continue;
            }
            $this->schema->executeProcedure('import_ical_to_contactmoment', [$userId, $event['SUMMARY'], $event['UID'], $this->convertToSQLDateTime($event['DTSTART']), $this->convertToSQLDateTime($event['DTEND']), $event['LOCATION']]);
            $count++;
        }
        $this->schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);

        return $count;
    }

    private function convertToSQLDateTime(string $icaldatetime): string
    {
        try {
            $datetime = new \DateTime($icaldatetime);
            $datetime->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
            return $datetime->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}

return function(\rikmeijer\Teach\Bootstrap $bootstrap) : User  {
    return new \rikmeijer\Teach\User($bootstrap->resource('sso'), $bootstrap->resource('session'), $bootstrap->resource('database'));
};
