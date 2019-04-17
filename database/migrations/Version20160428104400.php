<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160428104400 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
		Schema::table('contactmoment', function(Blueprint $table)
		{
		    $table->text('ical_uid')->nullable();
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
		    $table->dropColumn('ical_uid');
		});
    }
}
