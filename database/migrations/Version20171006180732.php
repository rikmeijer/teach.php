<?php

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171006180732 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        $contactmoment = $schema->getTable('contactmoment');

        $this->addSql('UPDATE  `contactmoment` SET `owner` = "hameijer"');

        $contactmoment->addForeignKeyConstraint('users', ['owner'], ['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
