<?php
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20160413155014 extends AbstractMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(Schema $schema) : void
	{
		$table = $schema->createTable('doelgroep');
        $table->integer('id', true);
        $table->enum('ervaring', array('veel','redelijk veel','weinig','geen'));
        $table->integer('grootte');
        $table->text('beschrijving', 65535)->nullable();
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(Schema $schema) : void
	{
		$schema->dropTable('doelgroep');
	}

}
