<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180419092816 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("DROP VIEW contactmomentrating");
    }

    public function down(Schema $schema)
    {
        $this->addSql("CREATE VIEW contactmomentrating AS
            SELECT rating.contactmoment_id, ROUND(SUM(rating.waarde)/COUNT(rating.waarde)) AS waarde FROM `rating` GROUP BY contactmoment_id");
    }
}
