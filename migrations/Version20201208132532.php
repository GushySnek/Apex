<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208132532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnage_skill DROP FOREIGN KEY FK_F46EE84D5E315342');
        $this->addSql('ALTER TABLE personnage_tag DROP FOREIGN KEY FK_F0D1CEFF5E315342');
        $this->addSql('CREATE TABLE hero (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) NOT NULL, role VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hero_tag (hero_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_8D8C3A1645B0BCD (hero_id), INDEX IDX_8D8C3A16BAD26311 (tag_id), PRIMARY KEY(hero_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hero_skill (hero_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_C102EBB045B0BCD (hero_id), INDEX IDX_C102EBB05585C142 (skill_id), PRIMARY KEY(hero_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hero_tag ADD CONSTRAINT FK_8D8C3A1645B0BCD FOREIGN KEY (hero_id) REFERENCES hero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hero_tag ADD CONSTRAINT FK_8D8C3A16BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hero_skill ADD CONSTRAINT FK_C102EBB045B0BCD FOREIGN KEY (hero_id) REFERENCES hero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hero_skill ADD CONSTRAINT FK_C102EBB05585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE personnage');
        $this->addSql('DROP TABLE personnage_skill');
        $this->addSql('DROP TABLE personnage_tag');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero_tag DROP FOREIGN KEY FK_8D8C3A1645B0BCD');
        $this->addSql('ALTER TABLE hero_skill DROP FOREIGN KEY FK_C102EBB045B0BCD');
        $this->addSql('CREATE TABLE personnage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personnage_skill (personnage_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_F46EE84D5585C142 (skill_id), INDEX IDX_F46EE84D5E315342 (personnage_id), PRIMARY KEY(personnage_id, skill_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personnage_tag (personnage_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_F0D1CEFF5E315342 (personnage_id), INDEX IDX_F0D1CEFFBAD26311 (tag_id), PRIMARY KEY(personnage_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE personnage_skill ADD CONSTRAINT FK_F46EE84D5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage_skill ADD CONSTRAINT FK_F46EE84D5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage_tag ADD CONSTRAINT FK_F0D1CEFF5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage_tag ADD CONSTRAINT FK_F0D1CEFFBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE hero');
        $this->addSql('DROP TABLE hero_tag');
        $this->addSql('DROP TABLE hero_skill');
    }
}
