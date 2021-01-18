<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216132904 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, id_professeur_id INT DEFAULT NULL, nom_classe VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2ED7EC549AFF8C (id_professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proffesseur (id INT AUTO_INCREMENT NOT NULL, nom_professeur VARCHAR(255) NOT NULL, prenom_professeur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classes ADD CONSTRAINT FK_2ED7EC549AFF8C FOREIGN KEY (id_professeur_id) REFERENCES proffesseur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classes DROP FOREIGN KEY FK_2ED7EC549AFF8C');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE proffesseur');
    }
}
