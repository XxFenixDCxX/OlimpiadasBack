<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423074558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, purchase_history_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_3BAE0AA71236D398 (purchase_history_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_history (id INT AUTO_INCREMENT NOT NULL, transaction_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_3C60BA322FC0CB0F (transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, slots INT NOT NULL, price INT NOT NULL, INDEX IDX_2D737AEF71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, user_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA71236D398 FOREIGN KEY (purchase_history_id) REFERENCES purchase_history (id)');
        $this->addSql('ALTER TABLE purchase_history ADD CONSTRAINT FK_3C60BA322FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transactions (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE users ADD purchase_history_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E91236D398 FOREIGN KEY (purchase_history_id) REFERENCES purchase_history (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E91236D398 ON users (purchase_history_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E91236D398');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA71236D398');
        $this->addSql('ALTER TABLE purchase_history DROP FOREIGN KEY FK_3C60BA322FC0CB0F');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF71F7E88B');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE purchase_history');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP INDEX IDX_1483A5E91236D398 ON users');
        $this->addSql('ALTER TABLE users DROP purchase_history_id');
    }
}
