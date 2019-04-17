<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190417083700 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('password_resets');
        $table->setPrimaryKey(['email', 'token']);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('password_resets');
        $table->dropPrimaryKey();
    }
}
