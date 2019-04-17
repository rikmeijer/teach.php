<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

final class Version20141012000000 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('users');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->setPrimaryKey(['id']);
        $table->addColumn('name', 'string');
        $table->addColumn('email', 'string');
        $table->addUniqueIndex(['email']);
        $table->addColumn('password', 'string');
        $table->addColumn('remember_token', 'string')->setLength(100)->setNotnull(false);
        $table->addColumn('updated_at', 'datetime')->setNotnull(false);
        $table->addColumn('created_at', 'datetime')->setNotnull(false);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Schema $schema) : void
    {
        $schema->dropTable('users');
    }
}
