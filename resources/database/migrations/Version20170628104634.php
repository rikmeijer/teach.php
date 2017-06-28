<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170628104634 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE PROCEDURE rate_contactmoment(contactmoment_id INT, ipv4_remote_address VARCHAR(15), waarde VARCHAR(5), inhoud TEXT)
            BEGIN
                INSERT INTO `rating`
                    (`contactmoment_id`, `ipv4`, `waarde`, `inhoud`, `created_at`, `updated_at`)
                VALUES
                    (contactmoment_id, ipv4_remote_address, waarde, inhoud, NOW(), NOW())
                ON DUPLICATE KEY
                UPDATE
                    `waarde` = waarde, 
                    `inhoud` = inhoud,
                    `updated_at` = NOW();
            END;
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP PROCEDURE rate_contactmoment;');
    }
}
