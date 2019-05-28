<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190528130305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('DROP VIEW `contactmoment_toekomst_geimporteerd_verleden`');
        $this->addSql('CREATE VIEW `contactmoment_toekomst_geimporteerd_verleden` AS select `contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at`, `contactmoment`.`owner` as `owner` from `contactmoment` where `contactmoment`.`starttijd` > curdate() and `contactmoment`.`ical_uid` is not null and (`contactmoment`.`updated_at` < curdate() or `contactmoment`.`updated_at` is null)');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP VIEW `contactmoment_toekomst_geimporteerd_verleden`');
        $this->addSql('CREATE VIEW `contactmoment_toekomst_geimporteerd_verleden` AS select `contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at` from `contactmoment` where `contactmoment`.`starttijd` > curdate() and `contactmoment`.`ical_uid` is not null and (`contactmoment`.`updated_at` < curdate() or `contactmoment`.`updated_at` is null)');
    }
}
