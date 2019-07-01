<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190701094704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'move e-mail addresses';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('TRUNCATE TABLE useremailaddresses');
        $this->addSql('INSERT INTO useremailaddresses (`email`, `userid`) SELECT email, id FROM users');
        $this->addSql('ALTER TABLE `users` add constraint `primary_email` foreign key (`email`) references `useremailaddresses` (`email`) on update cascade on delete restrict');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE users drop constraint primary_email');
    }
}
