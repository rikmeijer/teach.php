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
        $this->addSql('CREATE PROCEDURE import_ical_to_contactmoment(module_id INT(11), ical_uid TEXT, ical_start DATETIME, ical_end DATETIME, ical_location TEXT)
            BEGIN
                DECLARE les_id INT;
                DECLARE jaar INT(4);
                DECLARE kalenderweek INT(2);
                
                SET kalenderweek = WEEK(ical_start, 3);
                SET jaar = YEAR(ical_start);
                
                SELECT les.id INTO les_id
                FROM les
                WHERE
                    `module_id` = module_id AND
                    `kalenderweek` = kalenderweek AND
                    `jaar` = jaar
                LIMIT 1;
                
                IF les_id IS NULL THEN 
                    INSERT INTO les 
                        (`module_id`, `kalenderweek`, `jaar`, `naam`, `created_at`, `updated_at`) 
                    VALUES 
                        (module_id, kalenderweek, jaar, \'\', NOW(), NOW()); 
                    SET @les_id = LAST_INSERT_ID();
                END IF;
            
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
