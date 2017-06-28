<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170628111017 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE PROCEDURE import_ical_to_contactmoment(les_id INT(11), ical_uid TEXT, ical_start DATETIME, ical_end DATETIME, ical_location TEXT)
            BEGIN
                INSERT INTO contactmoment
                    (`les_id`, `starttijd`, `eindtijd`, `ruimte`, `ical_uid`, `created_at`, `updated_at`)
                VALUES
                    (les_id, ical_start, ical_end, ical_location, ical_uid, NOW(), NOW())
                ON DUPLICATE KEY UPDATE
                    `starttijd` = ical_start, 
                    `eindtijd` = ical_end, 
                    `ruimte` = ical_location, 
                    `updated_at` = NOW();
            END;
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP PROCEDURE import_ical_to_contactmoment;');
    }
}
