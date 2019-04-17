<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170202161307 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
        Schema::table('les', function(Blueprint $table)
        {
            $table->foreign(['module_id'], 'fk_lesmodule')->references(['id'])->on('module')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
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
            $table->dropForeign('fk_lesmodule');
        });
    }
}
