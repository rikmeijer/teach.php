<?php return new class implements \rikmeijer\Teach\Route
{
    public function __invoke(
        \Psr\Http\Message\RequestInterface $request,
        \rikmeijer\Teach\Resources $resources,
        \rikmeijer\Teach\Response $response
    ): \Psr\Http\Message\ResponseInterface {
        $schema = $resources->schema();

        $icalReader = $resources->iCalReader($request->getParsedBody()['url']);

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
                $lesplan = $module->fetchFirstByFkLesmodule([
                    'jaar' => $resources->convertToYear($event['DTSTART']),
                    'kalenderweek' => $resources->convertToWeek($event['DTSTART'])
                ]);

                if ($lesplan->naam === null) {
                    $lesplan->naam = "";
                }
                $contactmoment->les_id = $lesplan->id;
            }

            $contactmoment->ical_uid = $event['UID'];
            $contactmoment->starttijd = $resources->convertToSQLDateTime($event['DTSTART']);
            $contactmoment->eindtijd = $resources->convertToSQLDateTime($event['DTEND']);
            $contactmoment->ruimte = $event['LOCATION'];
            $contactmoment->updated_at = date('Y-m-d H:i:s');
        }

        // remove future, imported contactmomenten which where not touched in this batch (today)
        $schema->delete('contactmoment_toekomst_geimporteerd_verleden', []);

        return $response->make(201, $resources->phpview()->capture('contactmoment/imported', []));
    }
};