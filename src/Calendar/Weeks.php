<?php


namespace rikmeijer\Teach\Calendar;

use pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\Calendar;
use rikmeijer\Teach\Daos\LesweekDao;

class Weeks implements Calendar
{
    /**
     * @var LesweekDao
     */
    private $lesweken;

    /**
     * @var \Eluceo\iCal\Component\Calendar
     */
    private $icalGenerator;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->lesweken = $bootstrap->resource('dao')('Lesweek');
        $this->icalGenerator = $bootstrap->resource('ical-generator')('weeks');;
    }

    final public function generate() : string
    {
        foreach ($this->lesweken->findAll() as $lesweek) {
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
                $this->icalGenerator->addComponent($lesweekEvent);
            } catch (\Exception $e) {
            }
        }
        return $this->icalGenerator->render();
    }

}
