<?php
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20160413155112 extends AbstractMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(Schema $schema) : void
	{
		Schema::table('contactmoment', function(Blueprint $table)
		{
			$table->foreign('les_id', 'fk_les')->references('id')->on('les')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(Schema $schema) : void
	{
		Schema::table('contactmoment', function(Blueprint $table)
		{
			$table->dropForeign('fk_les');
		});
	}

}
