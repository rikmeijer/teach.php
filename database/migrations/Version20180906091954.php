<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906091954 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("DROP VIEW contactmoment_vandaag");
        $this->addSql("
            CREATE VIEW contactmoment_vandaag AS
                SELECT lesweek.kalenderweek, lesweek.blokweek, contactmoment.*
                FROM contactmoment
                JOIN les ON contactmoment.les_id = les.id
                JOIN lesweek ON les.jaar = lesweek.jaar AND les.kalenderweek = lesweek.kalenderweek
                WHERE DATE(starttijd) = CURDATE()
                ORDER BY starttijd ASC
            ");
    }

    public function down(Schema $schema) : void
    {
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
}