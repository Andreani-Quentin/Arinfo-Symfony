<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216141558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC549AFF8C');
        $this->addSql('DROP INDEX UNIQ_2ED7EC549AFF8C ON classes');
        $this->addSql('ALTER TABLE classes CHANGE id_professeur_id professeur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC5BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES proffesseur (id)');
        $this->addSql('CREATE INDEX IDX_2ED7EC5BAB22EE9 ON classes (professeur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC5BAB22EE9');
        $this->addSql('DROP INDEX IDX_2ED7EC5BAB22EE9 ON classes');
        $this->addSql('ALTER TABLE classes CHANGE professeur_id id_professeur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC549AFF8C FOREIGN KEY (id_professeur_id) REFERENCES proffesseur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2ED7EC549AFF8C ON classes (id_professeur_id)');
    }
}
