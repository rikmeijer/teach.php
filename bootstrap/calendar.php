<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    $bootstrap->resource('phpview')->registerHelper('calendar', function(\pulledbits\View\TemplateInstance $templateInstance, string $calendarIdentifier) : \Eluceo\iCal\Component\Calendar
    {
        $calendar = new \Eluceo\iCal\Component\Calendar($calendarIdentifier);
        switch ($calendarIdentifier) {
            case 'weeks':
                $lesweken = $templateInstance->resource('database')->read('lesweek', [], []);
                foreach ($lesweken as $lesweek) {
                    $lesweekEvent = new \Eluceo\iCal\Component\Event();
                    $lesweekEvent->setNoTime(true);
                    $lesweekEvent->setUniqueId(sha1($lesweek->jaar . $lesweek->kalenderweek));
                    $lesweekEvent->setSummary('OW' . $lesweek->onderwijsweek . '/BW' . $lesweek->blokweek);
                    try {
                        $week_start = new \DateTime();
                        $week_start->setISODate($lesweek->jaar, $lesweek->kalenderweek);
                        $lesweekEvent->setDtStart($week_start);
                        $lesweekEvent->setDtEnd($week_start);
                        $calendar->addComponent($lesweekEvent);
                    } catch (\Exception $e) {
                    }
                }
                break;

            default:
                error_log('Unknown calendar ' . $calendarIdentifier . ' requested');
                break;
        }
        return $calendar;
    });
};
