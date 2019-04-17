<?php

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171006175327 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO users (`id`, `name`, `email`, `created_at`, `updated_at`) VALUES ("hameijer", "H.A. Meijer", "ha.meijer@avans.nl", NOW(), NOW())');

        $contactmoment = $schema->getTable('contactmoment');
        $contactmoment->addColumn('owner', 'string', [
            'length' => 255,
            'fixed' => false
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
