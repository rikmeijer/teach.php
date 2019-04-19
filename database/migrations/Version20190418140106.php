<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190418140106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('DROP VIEW `contactmoment_module`');
        $this->addSql('DROP VIEW `contactmoment_vandaag`');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE VIEW `contactmoment_module` AS select `module`.`naam` AS `modulenaam`,`lesweek`.`kalenderweek` AS `kalenderweek`,`lesweek`.`blokweek` AS `blokweek`,`contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at`,`contactmoment`.`owner` AS `owner` from (((`module` join `les` on(`les`.`module_naam` = `module`.`naam`)) join `contactmoment` on(`contactmoment`.`les_id` = `les`.`id`)) join `lesweek` on(`les`.`jaar` = `lesweek`.`jaar` and `les`.`kalenderweek` = `lesweek`.`kalenderweek`))');
        $this->addSql('CREATE VIEW `contactmoment_vandaag` AS select `lesweek`.`kalenderweek` AS `kalenderweek`,`lesweek`.`blokweek` AS `blokweek`,`module`.`naam` AS `modulenaam`,`contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at`,`contactmoment`.`owner` AS `owner` from (((`contactmoment` join `les` on(`contactmoment`.`les_id` = `les`.`id`)) join `lesweek` on(`les`.`jaar` = `lesweek`.`jaar` and `les`.`kalenderweek` = `lesweek`.`kalenderweek`)) join `module` on(`les`.`module_naam` = `module`.`naam`)) where cast(`contactmoment`.`starttijd` as date) = curdate() order by `contactmoment`.`starttijd`');
    }
}
