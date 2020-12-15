<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214163905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hero_tag (hero_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_8D8C3A1645B0BCD (hero_id), INDEX IDX_8D8C3A16BAD26311 (tag_id), PRIMARY KEY(hero_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_tag (news_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_BE3ED8A1B5A459A0 (news_id), INDEX IDX_BE3ED8A1BAD26311 (tag_id), PRIMARY KEY(news_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon_tag (weapon_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_A1C447B495B82273 (weapon_id), INDEX IDX_A1C447B4BAD26311 (tag_id), PRIMARY KEY(weapon_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hero_tag ADD CONSTRAINT FK_8D8C3A1645B0BCD FOREIGN KEY (hero_id) REFERENCES hero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hero_tag ADD CONSTRAINT FK_8D8C3A16BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_tag ADD CONSTRAINT FK_BE3ED8A1B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_tag ADD CONSTRAINT FK_BE3ED8A1BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon_tag ADD CONSTRAINT FK_A1C447B495B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon_tag ADD CONSTRAINT FK_A1C447B4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE hero_news');
        $this->addSql('DROP TABLE weapon_news');
        $this->addSql('ALTER TABLE news DROP type');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero_tag DROP FOREIGN KEY FK_8D8C3A16BAD26311');
        $this->addSql('ALTER TABLE news_tag DROP FOREIGN KEY FK_BE3ED8A1BAD26311');
        $this->addSql('ALTER TABLE weapon_tag DROP FOREIGN KEY FK_A1C447B4BAD26311');
        $this->addSql('CREATE TABLE hero_news (hero_id INT NOT NULL, news_id INT NOT NULL, INDEX IDX_9D38FB1645B0BCD (hero_id), INDEX IDX_9D38FB16B5A459A0 (news_id), PRIMARY KEY(hero_id, news_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE weapon_news (weapon_id INT NOT NULL, news_id INT NOT NULL, INDEX IDX_A5CC71AF95B82273 (weapon_id), INDEX IDX_A5CC71AFB5A459A0 (news_id), PRIMARY KEY(weapon_id, news_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE hero_news ADD CONSTRAINT FK_9D38FB1645B0BCD FOREIGN KEY (hero_id) REFERENCES hero (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hero_news ADD CONSTRAINT FK_9D38FB16B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon_news ADD CONSTRAINT FK_A5CC71AF95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon_news ADD CONSTRAINT FK_A5CC71AFB5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE hero_tag');
        $this->addSql('DROP TABLE news_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE weapon_tag');
        $this->addSql('ALTER TABLE news ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
