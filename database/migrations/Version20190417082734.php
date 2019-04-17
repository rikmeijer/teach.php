<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190417082734 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('migrations');
        $table->changeColumn('migration', [
            'type' => Type::getType('string'),
            'length' => 255
        ]);
        $table->setPrimaryKey(['migration']);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('migrations');
        $table->dropPrimaryKey();
        $table->changeColumn('migration', [
            'length' => null
        ]);
    }
}
