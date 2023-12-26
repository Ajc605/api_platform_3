<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231202131638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON api_token');
        $this->addSql('ALTER TABLE api_token DROP id');
        $this->addSql('ALTER TABLE api_token ADD PRIMARY KEY (token)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON api_token');
        $this->addSql('ALTER TABLE api_token ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE api_token ADD PRIMARY KEY (id, token)');
    }
}
