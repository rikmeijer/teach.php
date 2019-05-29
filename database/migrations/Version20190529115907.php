<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190529115907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $schema->dropTable('password_resets');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE password_resets (email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, token VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME DEFAULT NULL, INDEX password_resets_token_index (token), INDEX password_resets_email_index (email), PRIMARY KEY(email, token)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
    }
}
