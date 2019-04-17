<?php
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20160413155018 extends AbstractMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(Schema $schema) : void
	{
		$table = $schema->createTable('student');
			$table->integer('id', true);
			$table->addColumn('nummer', 'string', 7)->nullable()->unique('nummer');
			$table->addColumn('roepnaam', 'string', 50)->nullable();
			$table->addColumn('tussenvoegsel', 'string', 10)->nullable();
			$table->addColumn('achternaam', 'string', 50)->nullable();
			$table->integer('studentgroep_id')->nullable();
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(Schema $schema) : void
	{
		$schema->dropTable('student');
	}

}
