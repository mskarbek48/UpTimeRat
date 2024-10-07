<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241004073947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE monitor_status (id INT AUTO_INCREMENT NOT NULL, status_code INT NOT NULL, message VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, response_time DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, monitor_id INT NOT NULL, INDEX IDX_A4B73EEE4CE1C902 (monitor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE monitor_status ADD CONSTRAINT FK_A4B73EEE4CE1C902 FOREIGN KEY (monitor_id) REFERENCES monitor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monitor_status DROP FOREIGN KEY FK_A4B73EEE4CE1C902');
        $this->addSql('DROP TABLE monitor_status');
    }
}
