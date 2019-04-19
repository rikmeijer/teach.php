<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190417193823 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contactmoment (id INT AUTO_INCREMENT NOT NULL, les_id INT NOT NULL, owner VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, starttijd DATETIME NOT NULL, eindtijd DATETIME NOT NULL, ruimte TEXT DEFAULT NULL COLLATE utf8_unicode_ci, ical_uid VARCHAR(250) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX ical_uid (ical_uid), UNIQUE INDEX starttijd (starttijd), INDEX IDX_929E7431CF60E67C (owner), INDEX fk_contactmoment_les (les_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE les (id INT AUTO_INCREMENT NOT NULL, jaar VARCHAR(4) NOT NULL COLLATE utf8_unicode_ci, kalenderweek VARCHAR(2) NOT NULL COLLATE utf8_unicode_ci, module_naam VARCHAR(10) NOT NULL COLLATE utf8_unicode_ci, naam TEXT NOT NULL COLLATE utf8_unicode_ci, opmerkingen TEXT DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX fk_leslesweek (jaar, kalenderweek), INDEX fk_lesmodule (module_naam), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lesweek (jaar VARCHAR(4) NOT NULL COLLATE utf8_unicode_ci, kalenderweek VARCHAR(2) NOT NULL COLLATE utf8_unicode_ci, onderwijsweek VARCHAR(2) DEFAULT NULL COLLATE utf8_unicode_ci, blokweek VARCHAR(2) DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(jaar, kalenderweek)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE migrations (migration VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, batch INT NOT NULL, PRIMARY KEY(migration)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE module (naam VARCHAR(10) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX naam (naam), PRIMARY KEY(naam)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE password_resets (email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, token VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT NULL, INDEX password_resets_token_index (token), INDEX password_resets_email_index (email), PRIMARY KEY(email, token)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rating (ip VARCHAR(45) NOT NULL COLLATE utf8_unicode_ci, contactmoment_id INT NOT NULL, waarde VARCHAR(5) DEFAULT NULL COLLATE utf8_unicode_ci, inhoud TEXT DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX fk_rating_contactmoment (contactmoment_id), INDEX fk_rating_waarde (waarde), PRIMARY KEY(ip, contactmoment_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ratingwaarde (naam VARCHAR(5) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(naam)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, name TEXT NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, remember_token TEXT DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');

        $this->addSql('select `module`.`naam` AS `modulenaam`,`lesweek`.`kalenderweek` AS `kalenderweek`,`lesweek`.`blokweek` AS `blokweek`,`contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at`,`contactmoment`.`owner` AS `owner` from (((`module` join `les` on(`les`.`module_naam` = `module`.`naam`)) join `contactmoment` on(`contactmoment`.`les_id` = `les`.`id`)) join `lesweek` on(`les`.`jaar` = `lesweek`.`jaar` and `les`.`kalenderweek` = `lesweek`.`kalenderweek`))');
        $this->addSql('select `lesweek`.`kalenderweek` AS `kalenderweek`,`lesweek`.`blokweek` AS `blokweek`,`module`.`naam` AS `modulenaam`,`contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at`,`contactmoment`.`owner` AS `owner` from (((`contactmoment` join `les` on(`contactmoment`.`les_id` = `les`.`id`)) join `lesweek` on(`les`.`jaar` = `lesweek`.`jaar` and `les`.`kalenderweek` = `lesweek`.`kalenderweek`)) join `module` on(`les`.`module_naam` = `module`.`naam`)) where cast(`contactmoment`.`starttijd` as date) = curdate() order by `contactmoment`.`starttijd`');

        $this->addSql('select `contactmoment`.`id` AS `id`,`contactmoment`.`les_id` AS `les_id`,`contactmoment`.`starttijd` AS `starttijd`,`contactmoment`.`eindtijd` AS `eindtijd`,`contactmoment`.`ruimte` AS `ruimte`,`contactmoment`.`ical_uid` AS `ical_uid`,`contactmoment`.`created_at` AS `created_at`,`contactmoment`.`updated_at` AS `updated_at` from `contactmoment` where `contactmoment`.`starttijd` > curdate() and `contactmoment`.`ical_uid` is not null and (`contactmoment`.`updated_at` < curdate() or `contactmoment`.`updated_at` is null)');
        $this->addSql('CREATE DEFINER=`teach`@`localhost` PROCEDURE `rate_contactmoment`(IN `contactmoment_id` INT, IN `ip_remote_address` VARCHAR(15), IN `waarde` VARCHAR(5), IN `inhoud` TEXT) BEGIN INSERT INTO `rating` (`contactmoment_id`, `ip`, `waarde`, `inhoud`, `created_at`, `updated_at`) VALUES (contactmoment_id, ip_remote_address, waarde, inhoud, NOW(), NOW()) ON DUPLICATE KEY UPDATE `waarde` = waarde, `inhoud` = inhoud, `updated_at` = NOW(); END');
        $this->addSql('CREATE DEFINER=`teach`@`localhost` PROCEDURE `import_ical_to_contactmoment`(IN `owner` TEXT, IN `ical_summary` TEXT, IN `ical_uid` TEXT, IN `ical_start` DATETIME, IN `ical_end` DATETIME, IN `ical_location` TEXT) proc_label:BEGIN DECLARE _module_naam VARCHAR(10); DECLARE _les_id INT(11); DECLARE _jaar INT(4); DECLARE _kalenderweek INT(2); SELECT `module`.`naam` INTO _module_naam FROM `module` WHERE ical_summary RLIKE CONCAT(\'[[:<:]]\', `naam`, \'[[:>:]]\') LIMIT 1; IF _module_naam IS NULL THEN LEAVE proc_label; END IF; SET _kalenderweek = WEEK(ical_start, 3); SET _jaar = YEAR(ical_start); SELECT `les`.`id` INTO _les_id FROM `les` WHERE `module_naam` = _module_naam AND `kalenderweek` = _kalenderweek AND `jaar` = _jaar LIMIT 1; IF _les_id IS NULL THEN INSERT INTO les (`module_naam`, `kalenderweek`, `jaar`, `naam`, `created_at`, `updated_at`) VALUES (_module_naam, _kalenderweek, _jaar, \'\', NOW(), NOW()); SET _les_id = LAST_INSERT_ID(); END IF; INSERT INTO contactmoment (`les_id`, `starttijd`, `eindtijd`, `ruimte`, `ical_uid`, `owner`, `created_at`, `updated_at`) VALUES (_les_id, ical_start, ical_end, ical_location, ical_uid, owner, NOW(), NOW()) ON DUPLICATE KEY UPDATE `les_id` = _les_id, `starttijd` = ical_start, `eindtijd` = ical_end, `ruimte` = ical_location, `owner` = owner, `updated_at` = NOW(); END');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contactmoment');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE les');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE lesweek');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE migrations');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE module');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE password_resets');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE rating');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ratingwaarde');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users');
    }
}
