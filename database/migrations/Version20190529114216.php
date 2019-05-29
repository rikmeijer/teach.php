<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190529114216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO `ratingwaarde` (`naam`) VALUES ("0")');
        $this->addSql('UPDATE `rating` SET `waarde` = 0 WHERE `waarde` IS NULL');

        $schema->getTable('rating')->changeColumn('waarde', [
            'notnull' => true,
            'default' => 0
        ]);
        $schema->getTable('rating')->removeForeignKey('fk_rating_waarde');
        $schema->getTable('rating')->addForeignKeyConstraint('ratingwaarde', ['waarde'], ['naam'], [
            'onUpdate' => 'CASCADE',
            'onDelete' => 'RESTRICT'
        ]);

    }

    public function down(Schema $schema) : void
    {
        $schema->getTable('rating')->changeColumn('waarde', [
            'notnull' => false,
            'default' => null
        ]);
        $schema->getTable('rating')->removeForeignKey('fk_rating_waarde');
        $schema->getTable('rating')->addForeignKeyConstraint('ratingwaarde', ['waarde'], ['naam'], [
            'onUpdate' => 'CASCADE',
            'onDelete' => 'SET NULL'
        ]);
        $this->addSql('DELETE FROM `ratingwaarde` WHERE `naam` = "0"');
    }
}
