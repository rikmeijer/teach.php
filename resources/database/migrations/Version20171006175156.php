<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171006175156 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('users');

        $table->dropPrimaryKey();
        $table->dropColumn('password');
        $table->changeColumn('id', [
            'type' => Type::getType('string'),
            'length' => 255,
            'fixed' => false
        ]);
        $table->setPrimaryKey(['id']);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('users');
        $table->addColumn('password', [
            'type' => Type::getType('string')
        ]);
        $table->changeColumn('id', [
            'type' => Type::getType('integer'),
            'length' => 11
        ]);
    }
}
