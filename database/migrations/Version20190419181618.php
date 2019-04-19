<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190419181618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('DROP PROCEDURE `rate_contactmoment`');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE DEFINER=`teach`@`localhost` PROCEDURE `rate_contactmoment`(IN `contactmoment_id` INT, IN `ip_remote_address` VARCHAR(15), IN `waarde` VARCHAR(5), IN `inhoud` TEXT) BEGIN INSERT INTO `rating` (`contactmoment_id`, `ip`, `waarde`, `inhoud`, `created_at`, `updated_at`) VALUES (contactmoment_id, ip_remote_address, waarde, inhoud, NOW(), NOW()) ON DUPLICATE KEY UPDATE `waarde` = waarde, `inhoud` = inhoud, `updated_at` = NOW(); END');

    }
}
