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

    public function up(Schema $schema): void
    {
        $this->connection->executeQuery('alter table rating drop foreign key fk_rating_waarde');

        $this->connection->executeQuery('ALTER TABLE rating CHANGE waarde waarde VARCHAR(5) DEFAULT \'0\' NOT NULL COLLATE utf8_unicode_ci');

        try {
            $this->connection->insert('ratingwaarde', ['naam' => '0']);
        } catch (DBALException $e) {
        }
        $this->connection->update('rating', ['waarde' => '0'], ['waarde' => null]);


        $this->connection->executeQuery('alter table rating add constraint fk_rating_waarde foreign key (waarde) references ratingwaarde (naam) on update cascade on delete restrict');
    }


    public function down(Schema $schema): void
    {
        $this->connection->executeQuery('alter table rating drop foreign key fk_rating_waarde');

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
