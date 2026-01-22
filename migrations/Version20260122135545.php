<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260122135545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_section (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, INDEX position_idx (position), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE menu_section_item (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, position INT NOT NULL, section_id INT NOT NULL, INDEX IDX_E5A738B0D823E37A (section_id), INDEX section_position_idx (section_id, position), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE menu_section_item ADD CONSTRAINT FK_E5A738B0D823E37A FOREIGN KEY (section_id) REFERENCES menu_section (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_section_item DROP FOREIGN KEY FK_E5A738B0D823E37A');
        $this->addSql('DROP TABLE menu_section');
        $this->addSql('DROP TABLE menu_section_item');
    }
}
