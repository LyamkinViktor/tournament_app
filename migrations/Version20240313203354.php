<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313203354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tournament ADD standings JSON DEFAULT NULL, DROP date_from, DROP date_to');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tournament ADD date_from DATETIME NOT NULL, ADD date_to DATETIME NOT NULL, DROP standings');
    }
}
