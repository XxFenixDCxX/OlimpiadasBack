<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424170908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, short_text VARCHAR(255) NOT NULL, long_message VARCHAR(255) NOT NULL, is_readed TINYINT(1) NOT NULL, INDEX IDX_6000B0D367B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchases_history (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, section_id INT DEFAULT NULL, transaction_id INT DEFAULT NULL, slots INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_1EF5F3D3A76ED395 (user_id), INDEX IDX_1EF5F3D3D823E37A (section_id), INDEX IDX_1EF5F3D32FC0CB0F (transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, slots INT NOT NULL, price INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_2D737AEF71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, user_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, sub VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_zones (users_id INT NOT NULL, zones_id INT NOT NULL, INDEX IDX_62BD152167B3B43D (users_id), INDEX IDX_62BD1521A6EAEB7A (zones_id), PRIMARY KEY(users_id, zones_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zones (id INT AUTO_INCREMENT NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D367B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE purchases_history ADD CONSTRAINT FK_1EF5F3D3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE purchases_history ADD CONSTRAINT FK_1EF5F3D3D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE purchases_history ADD CONSTRAINT FK_1EF5F3D32FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transactions (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE users_zones ADD CONSTRAINT FK_62BD152167B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_zones ADD CONSTRAINT FK_62BD1521A6EAEB7A FOREIGN KEY (zones_id) REFERENCES zones (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D367B3B43D');
        $this->addSql('ALTER TABLE purchases_history DROP FOREIGN KEY FK_1EF5F3D3A76ED395');
        $this->addSql('ALTER TABLE purchases_history DROP FOREIGN KEY FK_1EF5F3D3D823E37A');
        $this->addSql('ALTER TABLE purchases_history DROP FOREIGN KEY FK_1EF5F3D32FC0CB0F');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF71F7E88B');
        $this->addSql('ALTER TABLE users_zones DROP FOREIGN KEY FK_62BD152167B3B43D');
        $this->addSql('ALTER TABLE users_zones DROP FOREIGN KEY FK_62BD1521A6EAEB7A');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE purchases_history');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_zones');
        $this->addSql('DROP TABLE zones');
    }
}
