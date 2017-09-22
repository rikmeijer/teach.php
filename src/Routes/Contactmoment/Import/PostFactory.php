<?php namespace rikmeijer\Teach\Routes\Contactmoment\Import;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;

class PostFactory implements ResponseFactory
{
    private $schema;
    private $responseFactory;
    private $phpview;
    private $icalReader;

    public function __construct(Schema $schema, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, \ICal $icalReader)
    {
        $this->schema = $schema;
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
        $this->icalReader = $icalReader;
    }

    public function makeResponse(): ResponseInterface
    {
        foreach ($this->icalReader->events() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            } elseif (array_key_exists('LOCATION', $event) === false) {
                continue;
            }
            $this->schema->executeProcedure('import_ical_to_contactmoment', [$event['SUMMARY'], $event['UID'], $this->convertToSQLDateTime($event['DTSTART']), $this->convertToSQLDateTime($event['DTEND']), $event['LOCATION']]);
        }
        $this->schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);
        return $this->responseFactory->make201($this->phpview->capture('imported', []));
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