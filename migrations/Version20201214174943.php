<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214174943 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero ADD CONSTRAINT FK_51CE6E86D60322AC FOREIGN KEY (role_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE hero ADD CONSTRAINT FK_51CE6E86BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('CREATE INDEX IDX_51CE6E86D60322AC ON hero (role_id)');
        $this->addSql('CREATE INDEX IDX_51CE6E86BAD26311 ON hero (tag_id)');
        $this->addSql('ALTER TABLE weapon ADD type_id INT NOT NULL, ADD tag_id INT NOT NULL, DROP type');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_6933A7E6C54C8C93 FOREIGN KEY (type_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_6933A7E6BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('CREATE INDEX IDX_6933A7E6C54C8C93 ON weapon (type_id)');
        $this->addSql('CREATE INDEX IDX_6933A7E6BAD26311 ON weapon (tag_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero DROP FOREIGN KEY FK_51CE6E86D60322AC');
        $this->addSql('ALTER TABLE hero DROP FOREIGN KEY FK_51CE6E86BAD26311');
        $this->addSql('DROP INDEX IDX_51CE6E86D60322AC ON hero');
        $this->addSql('DROP INDEX IDX_51CE6E86BAD26311 ON hero');
        $this->addSql('ALTER TABLE weapon DROP FOREIGN KEY FK_6933A7E6C54C8C93');
        $this->addSql('ALTER TABLE weapon DROP FOREIGN KEY FK_6933A7E6BAD26311');
        $this->addSql('DROP INDEX IDX_6933A7E6C54C8C93 ON weapon');
        $this->addSql('DROP INDEX IDX_6933A7E6BAD26311 ON weapon');
        $this->addSql('ALTER TABLE weapon ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP type_id, DROP tag_id');
    }
}
