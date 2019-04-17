<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170201164532 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
        DB::statement("
            CREATE VIEW contactmomenten_vandaag AS
                SELECT *
                FROM contactmoment
                WHERE DATE(starttijd) = CURDATE()
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Schema $schema) : void
    {
        DB::statement("DROP VIEW contactmomenten_vandaag");
    }
}
