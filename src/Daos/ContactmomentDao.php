<?php
/*
 * This file has been automatically generated by TDBM.
 * You can edit this file as it will not be overwritten.
 */

declare(strict_types=1);

namespace rikmeijer\Teach\Daos;

use rikmeijer\Teach\Beans\Module;
use rikmeijer\Teach\Daos\Generated\AbstractContactmomentDao;
use TheCodingMachine\TDBM\ResultIterator;

/**
 * The ContactmomentDao class will maintain the persistence of Contactmoment class into the contactmoment table.
 */
class ContactmomentDao extends AbstractContactmomentDao
{
    public function findContactmomentenForUserByModule(string $owner, Module $module) : ResultIterator {
        return $this->find('module.naam = :moduleName AND contactmoment.owner = :owner', ['moduleName' => $module->getNaam(), 'owner' => $owner]);
    }

    public function findContactmomentenTodayForUser(string $owner) : ResultIterator {
        return $this->find('DATE(contactmoment.starttijd) = curdate() AND contactmoment.owner = :owner', ['owner' => $owner]);
    }

    public function import(string $owner, array $events) {
        $dbal = $this->tdbmService->getConnection();
        $count = 0;
        foreach ($events as $event) {
            $procedureStatement = $dbal->prepare(
                'CALL import_ical_to_contactmoment(:owner, :eventSummary, :eventId, :eventStartTime, :eventEndTime, :eventLocation)'
            );
            $procedureStatement->execute($event);
            $count++;
        }
        $procedureStatement = $dbal->prepare('CALL delete_previously_imported_future_events(:owner)');
        $procedureStatement->execute(['owner' => $owner]);
        return $count;
    }
}
