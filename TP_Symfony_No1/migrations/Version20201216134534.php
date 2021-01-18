<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216134534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves ADD id_classe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1F6B192E FOREIGN KEY (id_classe_id) REFERENCES classes (id)');
        $this->addSql('CREATE INDEX IDX_383B09B1F6B192E ON eleves (id_classe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1F6B192E');
        $this->addSql('DROP INDEX IDX_383B09B1F6B192E ON eleves');
        $this->addSql('ALTER TABLE eleves DROP id_classe_id');
    }
}
