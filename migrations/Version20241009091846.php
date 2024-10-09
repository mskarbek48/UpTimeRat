<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009091846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE monitor_notification_settings (monitor_id INT NOT NULL, notification_settings_id INT NOT NULL, INDEX IDX_CC73976B4CE1C902 (monitor_id), INDEX IDX_CC73976B8C0FABC9 (notification_settings_id), PRIMARY KEY(monitor_id, notification_settings_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE monitor_notification_settings ADD CONSTRAINT FK_CC73976B4CE1C902 FOREIGN KEY (monitor_id) REFERENCES monitor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE monitor_notification_settings ADD CONSTRAINT FK_CC73976B8C0FABC9 FOREIGN KEY (notification_settings_id) REFERENCES notification_settings (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monitor_notification_settings DROP FOREIGN KEY FK_CC73976B4CE1C902');
        $this->addSql('ALTER TABLE monitor_notification_settings DROP FOREIGN KEY FK_CC73976B8C0FABC9');
        $this->addSql('DROP TABLE monitor_notification_settings');
    }
}
