<?php namespace rikmeijer\Teach\Routes\Contactmoment;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;

class Import implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/contactmoment/import$#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        $phpview = $this->resources->phpview('Contactmoment\\Import');
        $responseFactory = $this->resources->responseFactory();

        switch ($request->getMethod()) {
            case 'GET':
                return new class($phpview, $responseFactory) implements ResponseFactory
                {
                    private $responseFactory;
                    private $phpview;

                    public function __construct(\pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory)
                    {
                        $this->responseFactory = $responseFactory;
                        $this->phpview = $phpview;
                    }

                    public function makeResponse(): ResponseInterface
                    {
                        return $this->responseFactory->make200($this->phpview->capture('import', ['importForm' => function (): void {
                            $model = 'ICS URL: <input type="text" name="url" />';
                            $this->form("post", "Importeren", $model);
                        }]));
                    }
                };

            case 'POST':
                $icalReader = $this->resources->iCalReader($request->getParsedBody()['url']);
                $schema = $this->resources->schema();
                return new class($schema, $phpview, $responseFactory, $icalReader) implements ResponseFactory
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
                };

            default:
                return $responseFactory->make405('Method not allowed');
        }

    }
}