<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160419143924 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
		$table = $schema->createTable('rating');
        $table->addColumn('ipv4', 'string', 15);
        $table->integer('contactmoment_id')->index('fk_contactmomentrating_idx');
        $table->foreign('contactmoment_id')->references('id')->on('contactmoment');
        $table->enum('waarde', array('1','2','3','4','5'))->nullable();
        $table->text('inhoud', 65535);

        $table->addColumn('updated_at', 'datetime')->setNotnull(false);
        $table->addColumn('created_at', 'datetime')->setNotnull(false);
        $table->softDeletes();

        $table->primary(['ipv4', 'contactmoment_id']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Schema $schema) : void
    {
		$schema->dropTable('rating');
    }
}
