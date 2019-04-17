<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160510135018 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
		Schema::table('thema', function(Blueprint $table)
		{

        $table->addColumn('updated_at', 'datetime')->setNotnull(false);
        $table->addColumn('created_at', 'datetime')->setNotnull(false);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Schema $schema) : void
    {
		Schema::table('thema', function(Blueprint $table)
		{
		    $table->dropTimestamps();
		});
    }
}
