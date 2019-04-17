<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160428111445 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
		$table = $schema->createTable('lesweek');
        $table->addColumn('jaar', 'string', 4);
        $table->addColumn('kalenderweek', 'string', 2);
        $table->addColumn('onderwijsweek', 'string', 2)->nullable();
        $table->addColumn('blokweek', 'string', 2)->nullable();
        $table->primary(['jaar', 'kalenderweek'], 'weekjaar');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Schema $schema) : void
    {
		$schema->dropTable('lesweek');
    }
}
