<?php namespace rikmeijer\Teach\Routes\Contactmoment\Import;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\User;

class PostFactory implements RouteEndPoint
{
    private $schema;
    private $phpview;
    private $user;

    public function __construct(Schema $schema, \pulledbits\View\Template $phpview, User $user)
    {
        $this->schema = $schema;
        $this->phpview = $phpview;
        $this->user = $user;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        foreach ($this->user->retrieveCalendarEvents() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            } elseif (array_key_exists('LOCATION', $event) === false) {
                continue;
            }
            $this->schema->executeProcedure('import_ical_to_contactmoment', [$event['USERID'], $event['SUMMARY'], $event['UID'], $this->convertToSQLDateTime($event['DTSTART']), $this->convertToSQLDateTime($event['DTEND']), $event['LOCATION']]);
        }
        $this->schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);
        return $this->phpview->prepareAsResponse($psrResponse, []);
    }

    private function reformatDateTime(string $datetime, string $format): string
    {
        $datetime = new \DateTime($datetime);
        $datetime->setTimezone(new \DateTimeZone(ini_get('date.timezone')));
        return $datetime->format($format);
    }

    private function convertToSQLDateTime(string $datetime): string
    {
        return $this->reformatDateTime($datetime, 'Y-m-d H:i:s');
    }
}