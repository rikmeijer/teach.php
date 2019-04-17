<?php
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20160428125300 extends AbstractMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(Schema $schema) : void
	{
		Schema::table('les', function(Blueprint $table)
		{
			$table->addColumn('jaar', 'string', 4);
			$table->addColumn('kalenderweek', 'string', 2);
		});
		
		DB::statement("
		    UPDATE les
		    SET 
		      les.jaar = '2016', 
		      les.kalenderweek = '1'
		");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(Schema $schema) : void
	{
		Schema::table('les', function(Blueprint $table)
		{
			$table->dropColumn('jaar');
			$table->dropColumn('kalenderweek');
		});
	}

}
