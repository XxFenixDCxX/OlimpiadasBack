<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325123114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, sub VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_zones (users_id INT NOT NULL, zones_id INT NOT NULL, INDEX IDX_62BD152167B3B43D (users_id), INDEX IDX_62BD1521A6EAEB7A (zones_id), PRIMARY KEY(users_id, zones_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zones (id INT AUTO_INCREMENT NOT NULL, start DATE NOT NULL, end DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_zones ADD CONSTRAINT FK_62BD152167B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_zones ADD CONSTRAINT FK_62BD1521A6EAEB7A FOREIGN KEY (zones_id) REFERENCES zones (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_zones DROP FOREIGN KEY FK_62BD152167B3B43D');
        $this->addSql('ALTER TABLE users_zones DROP FOREIGN KEY FK_62BD1521A6EAEB7A');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_zones');
        $this->addSql('DROP TABLE zones');
    }
}
