<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230824120827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordinateurs ADD CONSTRAINT FK_A88D6BF30964F9C FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_A88D6BF30964F9C ON ordinateurs (marque_id)');
        $this->addSql('ALTER TABLE tablettes ADD marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE tablettes ADD CONSTRAINT FK_3E904A130964F9C FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_3E904A130964F9C ON tablettes (marque_id)');
        $this->addSql('ALTER TABLE telephones ADD marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE telephones ADD CONSTRAINT FK_6FCD09F30964F9C FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_6FCD09F30964F9C ON telephones (marque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE telephones DROP FOREIGN KEY FK_6FCD09F30964F9C');
        $this->addSql('DROP INDEX IDX_6FCD09F30964F9C ON telephones');
        $this->addSql('ALTER TABLE telephones DROP marque_id');
        $this->addSql('ALTER TABLE tablettes DROP FOREIGN KEY FK_3E904A130964F9C');
        $this->addSql('DROP INDEX IDX_3E904A130964F9C ON tablettes');
        $this->addSql('ALTER TABLE tablettes DROP marque_id');
        $this->addSql('ALTER TABLE ordinateurs DROP FOREIGN KEY FK_A88D6BF30964F9C');
        $this->addSql('DROP INDEX IDX_A88D6BF30964F9C ON ordinateurs');
    }
}
