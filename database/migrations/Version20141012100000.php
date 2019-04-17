<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20141012100000 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('password_resets');
        $table->addColumn('email', 'string');
        $table->addColumn('token', 'string');
        $table->addIndex(['email', 'token']);
        $table->timestamp('created_at');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Schema $schema) : void
    {
        $schema->dropTable('password_resets');
    }
}
