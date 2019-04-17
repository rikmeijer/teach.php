<?php
namespace DoctrineMigrations;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170217114418 extends AbstractMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(Schema $schema) : void
    {
        DB::statement("
            CREATE VIEW contactmoment_toekomst_geimporteerd_verleden AS
                SELECT *
                FROM contactmoment
                WHERE 
                    starttijd > curdate() and 
                    ical_uid is not null and 
                    (updated_at < curdate() or updated_at is null)
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(Schema $schema) : void
    {
        DB::statement("DROP VIEW contactmoment_toekomst_geimporteerd_verleden");
    }
}
