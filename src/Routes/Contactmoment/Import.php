<?php namespace rikmeijer\Teach\Routes\Contactmoment;

class Import implements \pulledbits\Router\Handler
{
    private $resources;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview)
    {
        $this->resources = $resources;
        $this->phpview = $phpview;
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        switch ($request->getMethod()) {
            case 'GET':
                return $this->handleGetRequest($request);
            case 'POST':
                return $this->handlePostRequest($request);
            default:
                return $this->resources->respond(405, 'Method not allowed');
        }
    }

    private function handleGetRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        return $this->resources->respond(200, $this->phpview->capture('import', ['importForm' => function (): void {
            $model = 'ICS URL: <input type="text" name="url" />';

            $this->form("post", "Importeren", $model);
        }]));
    }

    private function handlePostRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $schema = $this->resources->schema();

        $icalReader = $this->resources->iCalReader($request->getParsedBody()['url']);

        foreach ($icalReader->events() as $event) {
            if (array_key_exists('SUMMARY', $event) === false) {
                continue;
            } elseif (array_key_exists('LOCATION', $event) === false) {
                continue;
            }

            $schema->executeProcedure('import_ical_to_contactmoment', [$event['SUMMARY'], $event['UID'], $this->resources->convertToSQLDateTime($event['DTSTART']), $this->resources->convertToSQLDateTime($event['DTEND']), $event['LOCATION']]);
        }

        // remove future, imported contactmomenten which where not touched in this batch (today)
        $schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);

        return $this->resources->respond(201, $this->phpview->capture('imported', []));
    }
}