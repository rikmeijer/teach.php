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
    private $icalReader;
    private $user;

    public function __construct(Schema $schema, \pulledbits\View\Template $phpview, \ICal $icalReader, User $user)
    {
        $this->schema = $schema;
        $this->phpview = $phpview;
        $this->icalReader = $icalReader;
        $this->user = $user;
    }

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        foreach ($this->icalReader->events() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            } elseif (array_key_exists('LOCATION', $event) === false) {
                continue;
            }
            $this->schema->executeProcedure('import_ical_to_contactmoment', [$this->user->getID(), $event['SUMMARY'], $event['UID'], $this->convertToSQLDateTime($event['DTSTART']), $this->convertToSQLDateTime($event['DTEND']), $event['LOCATION']]);
        }
        $this->schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);
        return $psrResponseFactory->makeWithTemplate('201', $this->phpview->prepare([]));
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