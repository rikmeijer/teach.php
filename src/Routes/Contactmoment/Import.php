<?php namespace rikmeijer\Teach\Routes\Contactmoment;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Handler;

class Import implements \pulledbits\Router\Matcher
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

    public function makeHandler(ServerRequestInterface $request): Handler
    {
        switch ($request->getMethod()) {
            case 'GET':
                return new class($this->resources, $this->resources->phpview('Contactmoment\\Import'), $this->resources->responseFactory()) implements Handler
                {
                    private $resources;
                    private $responseFactory;
                    private $phpview;

                    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory)
                    {
                        $this->resources = $resources;
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
                return new class($this->resources, $this->resources->phpview('Contactmoment\\Import'), $this->resources->responseFactory(), $request->getParsedBody()) implements Handler
                {
                    private $resources;
                    private $responseFactory;
                    private $phpview;
                    private $parsedBody;

                    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, array $parsedBody)
                    {
                        $this->resources = $resources;
                        $this->responseFactory = $responseFactory;
                        $this->phpview = $phpview;
                        $this->parsedBody = $parsedBody;
                    }

                    public function makeResponse(): ResponseInterface
                    {
                        $schema = $this->resources->schema();
                        $icalReader = $this->resources->iCalReader($this->parsedBody['url']);
                        foreach ($icalReader->events() as $event) {
                            if (array_key_exists('SUMMARY', $event) === false) {
                                continue;
                            } elseif (array_key_exists('LOCATION', $event) === false) {
                                continue;
                            }
                            $schema->executeProcedure('import_ical_to_contactmoment', [$event['SUMMARY'], $event['UID'], $this->convertToSQLDateTime($event['DTSTART']), $this->convertToSQLDateTime($event['DTEND']), $event['LOCATION']]);
                        }
                        $schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);
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
                return $this->responseFactory->make405('Method not allowed');
        }

    }
}