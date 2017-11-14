<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171114082409 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP VIEW contactmoment_module");
        $this->addSql("
            CREATE VIEW contactmoment_module AS
                SELECT module.id AS module_id, lesweek.kalenderweek, lesweek.blokweek, contactmoment.*
                FROM module
                JOIN les ON les.module_id = module.id
                JOIN contactmoment ON contactmoment.les_id = les.id
                JOIN lesweek ON les.jaar = lesweek.jaar AND les.kalenderweek = lesweek.kalenderweek
            ");


        $this->addSql("DROP VIEW contactmoment_vandaag");
        $this->addSql("
            CREATE VIEW contactmoment_vandaag AS
                SELECT lesweek.kalenderweek, lesweek.blokweek, contactmoment.*
                FROM contactmoment
                JOIN les ON contactmoment.les_id = les.id
                JOIN lesweek ON les.jaar = lesweek.jaar AND les.kalenderweek = lesweek.kalenderweek
                WHERE DATE(starttijd) = CURDATE()
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP VIEW contactmoment_module");
        $this->addSql("
            CREATE VIEW contactmoment_module AS
                SELECT module.id AS module_id, contactmoment.*
                FROM module
                JOIN les ON les.module_id = module.id
                JOIN contactmoment ON contactmoment.les_id = les.id
            ");


        $this->addSql("DROP VIEW contactmoment_vandaag");
        $this->addSql("
            CREATE VIEW contactmoment_vandaag AS
                SELECT *
                FROM contactmoment
                WHERE DATE(starttijd) = CURDATE()
            ");
    }
}
