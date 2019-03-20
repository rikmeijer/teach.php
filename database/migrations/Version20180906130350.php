<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906130350 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('DROP PROCEDURE import_ical_to_contactmoment;');
        $this->addSql('CREATE PROCEDURE import_ical_to_contactmoment(owner TEXT, ical_summary TEXT, ical_uid TEXT, ical_start DATETIME, ical_end DATETIME, ical_location TEXT)
            proc_label:BEGIN
                DECLARE _module_naam VARCHAR(10);
                DECLARE _les_id INT(11);
                DECLARE _jaar INT(4);
                DECLARE _kalenderweek INT(2);
                
                SELECT `module`.`naam` INTO _module_naam
                FROM `module`
                WHERE ical_summary RLIKE CONCAT(\'[[:<:]]\', `naam`, \'[[:>:]]\')
                LIMIT 1;
                
                IF _module_naam IS NULL THEN LEAVE proc_label;
                END IF;
                
                SET _kalenderweek = WEEK(ical_start, 3);
                SET _jaar = YEAR(ical_start);
                
                SELECT `les`.`id` INTO _les_id
                FROM `les`
                WHERE
                    `module_naam` = _module_naam AND
                    `kalenderweek` = _kalenderweek AND
                    `jaar` = _jaar
                LIMIT 1;
                
                IF _les_id IS NULL THEN 
                    INSERT INTO les 
                        (`module_naam`, `kalenderweek`, `jaar`, `naam`, `created_at`, `updated_at`) 
                    VALUES 
                        (_module_naam, _kalenderweek, _jaar, \'\', NOW(), NOW()); 
                    SET _les_id = LAST_INSERT_ID();
                END IF;
            
            
                INSERT INTO contactmoment
                    (`les_id`, `starttijd`, `eindtijd`, `ruimte`, `ical_uid`, `owner`, `created_at`, `updated_at`)
                VALUES
                    (_les_id, ical_start, ical_end, ical_location, ical_uid, owner, NOW(), NOW())
                ON DUPLICATE KEY UPDATE
                    `les_id` = _les_id,
                    `starttijd` = ical_start, 
                    `eindtijd` = ical_end, 
                    `ruimte` = ical_location, 
                    `owner` = owner,
                    `updated_at` = NOW();
            END;
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP PROCEDURE import_ical_to_contactmoment;');
        $this->addSql('CREATE PROCEDURE import_ical_to_contactmoment(owner TEXT, ical_summary TEXT, ical_uid TEXT, ical_start DATETIME, ical_end DATETIME, ical_location TEXT)
            proc_label:BEGIN
                DECLARE _module_id INT(11);
                DECLARE _les_id INT(11);
                DECLARE _jaar INT(4);
                DECLARE _kalenderweek INT(2);
                
                SELECT `module`.`id` INTO _module_id
                FROM `module`
                WHERE ical_summary RLIKE CONCAT(\'[[:<:]]\', `naam`, \'[[:>:]]\')
                LIMIT 1;
                
                IF _module_id IS NULL THEN LEAVE proc_label;
                END IF;
                
                SET _kalenderweek = WEEK(ical_start, 3);
                SET _jaar = YEAR(ical_start);
                
                SELECT `les`.`id` INTO _les_id
                FROM `les`
                WHERE
                    `module_id` = _module_id AND
                    `kalenderweek` = _kalenderweek AND
                    `jaar` = _jaar
                LIMIT 1;
                
                IF _les_id IS NULL THEN 
                    INSERT INTO les 
                        (`module_id`, `kalenderweek`, `jaar`, `naam`, `created_at`, `updated_at`) 
                    VALUES 
                        (_module_id, _kalenderweek, _jaar, \'\', NOW(), NOW()); 
                    SET _les_id = LAST_INSERT_ID();
                END IF;
            
            
                INSERT INTO contactmoment
                    (`les_id`, `starttijd`, `eindtijd`, `ruimte`, `ical_uid`, `owner`, `created_at`, `updated_at`)
                VALUES
                    (_les_id, ical_start, ical_end, ical_location, ical_uid, owner, NOW(), NOW())
                ON DUPLICATE KEY UPDATE
                    `les_id` = _les_id,
                    `starttijd` = ical_start, 
                    `eindtijd` = ical_end, 
                    `ruimte` = ical_location, 
                    `owner` = owner,
                    `updated_at` = NOW();
            END;
        ');
    }
}