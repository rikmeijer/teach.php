<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906103818 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE les ADD COLUMN module_naam VARCHAR(10) NOT NULL");
        $this->addSql("UPDATE les JOIN `module` ON les.module_id = `module`.id SET module_naam = `module`.naam");
        $this->addSql("ALTER TABLE les ADD FOREIGN KEY fk_lesmodule2 (module_naam) REFERENCES `module` (naam) ON UPDATE CASCADE ON DELETE RESTRICT");


        // alter code accordingly


    }

    public function down(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE DROP FOREIGN KEY fk_lesmodule2");
        $this->addSql("ALTER TABLE DROP COLUMN module_naam");
    }
}
