<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
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
        $schema->getTable('rating')->removeForeignKey('fk_rating_waarde');
        $schema->getTable('rating')->dropIndex('fk_rating_waarde');

        try {
            $this->connection->insert('ratingwaarde', ['naam' => '0']);
        } catch (DBALException $e) {

        }

        $this->connection->update('rating', ['waarde' => '0'], ['waarde' => null]);

        $schema->getTable('rating')->changeColumn('waarde', [
            'notnull' => true,
            'default' => 0
        ]);
        $schema->getTable('rating')->addForeignKeyConstraint('ratingwaarde', ['waarde'], ['naam'], [
            'onUpdate' => 'CASCADE',
            'onDelete' => 'RESTRICT'
        ]);

    }

    public function down(Schema $schema) : void
    {
        $schema->getTable('rating')->removeForeignKey('fk_rating_waarde');
        $schema->getTable('rating')->changeColumn('waarde', [
            'notnull' => false,
            'default' => null
        ]);
        $schema->getTable('rating')->addForeignKeyConstraint('ratingwaarde', ['waarde'], ['naam'], [
            'onUpdate' => 'CASCADE',
            'onDelete' => 'SET NULL'
        ]);
        $this->addSql('DELETE FROM `ratingwaarde` WHERE `naam` = "0"');
    }
}
