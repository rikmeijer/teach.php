<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170131152945 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
        DB::statement("
            CREATE VIEW leerdoelenView AS
                SELECT
                    thema.les_id,
                    thema.leerdoel as omschrijving
                FROM thema
            
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Schema $schema) : void
    {
        DB::statement("DROP VIEW leerdoelenView");
    }
}
