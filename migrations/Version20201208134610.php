<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208134610 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weapon DROP FOREIGN KEY FK_6933A7E67DAC73F3');
        $this->addSql('DROP INDEX IDX_6933A7E67DAC73F3 ON weapon');
        $this->addSql('ALTER TABLE weapon CHANGE ammo_type_id_id ammo_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_6933A7E620874E05 FOREIGN KEY (ammo_type_id) REFERENCES ammo_type (id)');
        $this->addSql('CREATE INDEX IDX_6933A7E620874E05 ON weapon (ammo_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weapon DROP FOREIGN KEY FK_6933A7E620874E05');
        $this->addSql('DROP INDEX IDX_6933A7E620874E05 ON weapon');
        $this->addSql('ALTER TABLE weapon CHANGE ammo_type_id ammo_type_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_6933A7E67DAC73F3 FOREIGN KEY (ammo_type_id_id) REFERENCES ammo_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6933A7E67DAC73F3 ON weapon (ammo_type_id_id)');
    }
}
