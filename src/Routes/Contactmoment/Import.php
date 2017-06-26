<?php namespace rikmeijer\Teach\Routes\Contactmoment;

class Import implements \pulledbits\Router\Handler
{
    private $resources;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources) {
        $this->resources = $resources;
        $this->phpview = $this->resources->phpview(__DIR__ . DIRECTORY_SEPARATOR . str_replace(__NAMESPACE__ . NAMESPACE_SEPARATOR,"",__CLASS__));
    }

    public function handleRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
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
            }

            if (preg_match('/(?<module>[A-Z]+\d{1,2})/', $event['SUMMARY'], $matches) !== 1) {
                $module = $schema->initializeRecord('module', ['naam' => null]);
            } else {
                $module = $schema->readFirst('module', [], ['naam' => $matches['module']]);
            }

            if ($module->id === null) {
                continue;
            }

            $contactmoment = $schema->readFirst('contactmoment', [], ['ical_uid' => $event['UID']]);

            if ($contactmoment->les_id === null) {
                $lesplan = $module->fetchFirstByFkLesmodule(['jaar' => $this->resources->convertToYear($event['DTSTART']), 'kalenderweek' => $resources->convertToWeek($event['DTSTART'])]);

                if ($lesplan->naam === null) {
                    $lesplan->naam = "";
                }
                $contactmoment->les_id = $lesplan->id;
            }

            $contactmoment->ical_uid = $event['UID'];
            $contactmoment->starttijd = $this->resources->convertToSQLDateTime($event['DTSTART']);
            $contactmoment->eindtijd = $this->resources->convertToSQLDateTime($event['DTEND']);
            $contactmoment->ruimte = $event['LOCATION'];
            $contactmoment->updated_at = date('Y-m-d H:i:s');
        }

        // remove future, imported contactmomenten which where not touched in this batch (today)
        $schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);

        return $this->resources->respond(201, $this->phpview->capture('imported', []));
    }
}