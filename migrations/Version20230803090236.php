<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230803090236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordinateurs ADD marque VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tablettes ADD marque VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE telephones ADD marque VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordinateurs DROP marque');
        $this->addSql('ALTER TABLE telephones DROP marque');
        $this->addSql('ALTER TABLE tablettes DROP marque');
    }
}
