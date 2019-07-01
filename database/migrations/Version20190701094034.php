<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190701094034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'create e-mail table and link to user table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('useremailaddresses');
        $table->addColumn('email', 'string', ['length' => 255]);
        $table->addColumn('userid', 'string', ['length' => 255]);

        $table->setPrimaryKey(['email']);
        $table->addForeignKeyConstraint('users', ['userid'], ['id'], [
            'onUpdate' => 'CASCADE',
            'onDelete' => 'CASCADE'
        ]);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('useremailaddresses');
    }
}
