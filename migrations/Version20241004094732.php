<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241004094732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status_page (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE status_page_monitor (status_page_id INT NOT NULL, monitor_id INT NOT NULL, INDEX IDX_D1CB6AEF4961461 (status_page_id), INDEX IDX_D1CB6AEF4CE1C902 (monitor_id), PRIMARY KEY(status_page_id, monitor_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE status_page_monitor ADD CONSTRAINT FK_D1CB6AEF4961461 FOREIGN KEY (status_page_id) REFERENCES status_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE status_page_monitor ADD CONSTRAINT FK_D1CB6AEF4CE1C902 FOREIGN KEY (monitor_id) REFERENCES monitor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status_page_monitor DROP FOREIGN KEY FK_D1CB6AEF4961461');
        $this->addSql('ALTER TABLE status_page_monitor DROP FOREIGN KEY FK_D1CB6AEF4CE1C902');
        $this->addSql('DROP TABLE status_page');
        $this->addSql('DROP TABLE status_page_monitor');
    }
}
