<?php
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20160413155017 extends AbstractMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(Schema $schema) : void
	{
		$table = $schema->createTable('module');
			$table->integer('id', true);
			$table->addColumn('naam', 'string', 50)->nullable()->unique('naam');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(Schema $schema) : void
	{
		$schema->dropTable('module');
	}

}
