<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211212231243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, status_type_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, number BIGINT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', modified_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1F1B251ECD9CFB16 (status_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_history (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, status_type_id INT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2F6A07CE126F525E (item_id), INDEX IDX_2F6A07CECD9CFB16 (status_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ECD9CFB16 FOREIGN KEY (status_type_id) REFERENCES status_type (id)');
        $this->addSql('ALTER TABLE status_history ADD CONSTRAINT FK_2F6A07CE126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE status_history ADD CONSTRAINT FK_2F6A07CECD9CFB16 FOREIGN KEY (status_type_id) REFERENCES status_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status_history DROP FOREIGN KEY FK_2F6A07CE126F525E');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251ECD9CFB16');
        $this->addSql('ALTER TABLE status_history DROP FOREIGN KEY FK_2F6A07CECD9CFB16');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE status_history');
        $this->addSql('DROP TABLE status_type');
    }
}
