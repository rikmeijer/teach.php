<?php
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20160413155020 extends AbstractMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(Schema $schema) : void
	{
		$table = $schema->createTable('studentgroep');
			$table->integer('id', true);
			$table->addColumn('naam', 'string', 5);
			$table->integer('blok_id')->index('fk_blok_idx');
			$table->unique(['naam','blok_id'], 'naam');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(Schema $schema) : void
	{
		$schema->dropTable('studentgroep');
	}

}
