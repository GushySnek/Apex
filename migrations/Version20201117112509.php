<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117112509 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE character_skill (character_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_A0FE03151136BE75 (character_id), INDEX IDX_A0FE03155585C142 (skill_id), PRIMARY KEY(character_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE character_skill ADD CONSTRAINT FK_A0FE03151136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_skill ADD CONSTRAINT FK_A0FE03155585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE skill_character');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill_character (skill_id INT NOT NULL, character_id INT NOT NULL, INDEX IDX_C08B8B691136BE75 (character_id), INDEX IDX_C08B8B695585C142 (skill_id), PRIMARY KEY(skill_id, character_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE skill_character ADD CONSTRAINT FK_C08B8B691136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_character ADD CONSTRAINT FK_C08B8B695585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE character_skill');
    }
}
