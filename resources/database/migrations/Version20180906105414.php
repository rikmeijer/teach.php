<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906105414 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("DROP VIEW IF EXISTS contactmoment_module");
        $this->addSql("
            CREATE VIEW contactmoment_module AS
                SELECT module.naam AS modulenaam, lesweek.kalenderweek, lesweek.blokweek, contactmoment.*
                FROM module
                JOIN les ON les.module_naam = module.naam
                JOIN contactmoment ON contactmoment.les_id = les.id
                JOIN lesweek ON les.jaar = lesweek.jaar AND les.kalenderweek = lesweek.kalenderweek
            ");

        $this->addSql("DROP VIEW contactmoment_vandaag");
        $this->addSql("
            CREATE VIEW contactmoment_vandaag AS
                SELECT lesweek.kalenderweek, lesweek.blokweek, module.naam as modulenaam, contactmoment.*
                FROM contactmoment
                JOIN les ON contactmoment.les_id = les.id
                JOIN lesweek ON les.jaar = lesweek.jaar AND les.kalenderweek = lesweek.kalenderweek
                JOIN module ON les.module_naam = module.naam
                WHERE DATE(starttijd) = CURDATE()
                ORDER BY starttijd ASC
            ");

        $this->addSql("ALTER TABLE les DROP FOREIGN KEY fk_lesmodule");
        $this->addSql("DROP INDEX fk_lesmodule ON les");

        $this->addSql("ALTER TABLE `module` DROP COLUMN id");

        $this->addSql("ALTER TABLE les DROP FOREIGN KEY fk_lesmodule2");
        $this->addSql("DROP INDEX fk_lesmodule2 ON les");

        $this->addSql("ALTER TABLE `module` DROP PRIMARY KEY, ADD PRIMARY KEY (naam)");
        $this->addSql("ALTER TABLE les ADD FOREIGN KEY `fk_lesmodule` (module_naam) REFERENCES `module` (naam) ON UPDATE CASCADE ON DELETE RESTRICT");

        $this->addSql("ALTER TABLE `les` DROP COLUMN module_id");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql("DROP VIEW contactmoment_module");
        $this->addSql("
            CREATE VIEW contactmoment_module AS
                SELECT module.id AS module_id, lesweek.kalenderweek, lesweek.blokweek, contactmoment.*
                FROM module
                JOIN les ON les.module_id = module.id
                JOIN contactmoment ON contactmoment.les_id = les.id
                JOIN lesweek ON les.jaar = lesweek.jaar AND les.kalenderweek = lesweek.kalenderweek
            ");

    }
}
