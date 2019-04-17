<?php
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20160413155012 extends AbstractMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(Schema $schema) : void
	{
		$table = $schema->createTable('blok');
			$table->integer('id', true);
			$table->addColumn('nummer', 'string', 45)->unique('nummer_UNIQUE');
			$table->enum('semester', array('1','2','3','4','5','6','7','8'))->index('fk_periode_idx');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(Schema $schema) : void
	{
		$schema->dropTable('blok');
	}

}
