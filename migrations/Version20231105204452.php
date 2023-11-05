<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105204452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE string_list (id INT AUTO_INCREMENT NOT NULL, next_id INT DEFAULT NULL, previous_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_created DATETIME NOT NULL, date_modified DATETIME NOT NULL, UNIQUE INDEX UNIQ_F3A3877BAA23F6C8 (next_id), UNIQUE INDEX UNIQ_F3A3877B2DE62210 (previous_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE string_list ADD CONSTRAINT FK_F3A3877BAA23F6C8 FOREIGN KEY (next_id) REFERENCES string_list (id)');
        $this->addSql('ALTER TABLE string_list ADD CONSTRAINT FK_F3A3877B2DE62210 FOREIGN KEY (previous_id) REFERENCES string_list (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE string_list DROP FOREIGN KEY FK_F3A3877BAA23F6C8');
        $this->addSql('ALTER TABLE string_list DROP FOREIGN KEY FK_F3A3877B2DE62210');
        $this->addSql('DROP TABLE string_list');
    }
}
