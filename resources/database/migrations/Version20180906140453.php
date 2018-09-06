<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906140453 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("SET FOREIGN_KEY_CHECKS=0");
        $this->addSql("DELETE FROM `contactmoment` WHERE ical_uid NOT LIKE CONCAT(\"Ical\",DATE_FORMAT(starttijd, \"%Y%m%dT%H:%i:%s\"),\"%\")");
        $this->addSql("ALTER TABLE contactmoment MODIFY ical_uid VARCHAR(250) NOT NULL UNIQUE");
        $this->addSql("SET FOREIGN_KEY_CHECKS=1");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE contactmoment MODIFY ical_uid TEXT NULL");
    }
}
