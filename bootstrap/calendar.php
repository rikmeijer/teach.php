<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    $bootstrap->resource('phpview')->registerHelper(
        'calendar',
        function (\pulledbits\View\TemplateInstance $templateInstance, string $calendarIdentifier) use ($bootstrap) : \Eluceo\iCal\Component\Calendar {
            $calendar = new \Eluceo\iCal\Component\Calendar($calendarIdentifier);
            switch ($calendarIdentifier) {
                case 'weeks':
                    /**
                     * @var \rikmeijer\Teach\Daos\LesweekDao $lesweken
                     */
                    $lesweken = $bootstrap->resource('dao')('Lesweek');
                    foreach ($lesweken->findAll() as $lesweek) {
                        $lesweekEvent = new \Eluceo\iCal\Component\Event();
                        $lesweekEvent->setNoTime(true);
                        $lesweekEvent->setUniqueId(sha1($lesweek->getJaar() . $lesweek->getKalenderweek()));
                        $lesweekEvent->setSummary(
                            'OW' . $lesweek->getOnderwijsweek() . '/BW' . $lesweek->getBlokweek()
                        );
                        try {
                            $week_start = new \DateTime();
                            $week_start->setISODate($lesweek->getJaar(), $lesweek->getKalenderweek());
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
        }
    );

    return new \rikmeijer\Teach\Calendar($bootstrap->resource('tdbm')->getConnection());
};
