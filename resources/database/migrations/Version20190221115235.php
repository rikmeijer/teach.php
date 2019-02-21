<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190221115235 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('DROP PROCEDURE rate_contactmoment');
        $this->addSql("ALTER TABLE rating CHANGE ipv4 ip VARCHAR(45)");
        $this->addSql('CREATE PROCEDURE rate_contactmoment(contactmoment_id INT, ip_remote_address VARCHAR(45), waarde VARCHAR(5), inhoud TEXT)
            BEGIN
                INSERT INTO `rating`
                    (`contactmoment_id`, `ip`, `waarde`, `inhoud`, `created_at`, `updated_at`)
                VALUES
                    (contactmoment_id, ip_remote_address, waarde, inhoud, NOW(), NOW())
                ON DUPLICATE KEY
                UPDATE
                    `waarde` = waarde, 
                    `inhoud` = inhoud,
                    `updated_at` = NOW();
            END;
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP PROCEDURE rate_contactmoment');
        $this->addSql("ALTER TABLE rating CHANGE ip ipv4 VARCHAR(15)");
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
}
