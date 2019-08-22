<?php


namespace rikmeijer\Teach;

use Doctrine\DBAL\Connection;
use pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\Daos\ContactmomentDao;
use rikmeijer\Teach\Daos\LesweekDao;

class Calendar
{
    /**
     * @var LesweekDao
     */
    private $lesweken;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->lesweken = $bootstrap->resource('dao')('Lesweek');
    }

    final public function generate(string $calendarIdentifier) : \Eluceo\iCal\Component\Calendar
    {
        $calendar = new \Eluceo\iCal\Component\Calendar($calendarIdentifier);
        switch ($calendarIdentifier) {
            case 'weeks':
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

}
