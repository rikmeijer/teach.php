<?php
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20160413155021 extends AbstractMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(Schema $schema) : void
	{
		$table = $schema->createTable('studentgroepcontact');
			$table->integer('studentgroep_id');
			$table->integer('contactmoment_id')->index('contactmoment_idx');
			$table->primary(['studentgroep_id','contactmoment_id']);
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(Schema $schema) : void
	{
		$schema->dropTable('studentgroepcontact');
	}

}
