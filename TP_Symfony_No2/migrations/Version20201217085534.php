<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217085534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, nom_club VARCHAR(255) NOT NULL, sport_club VARCHAR(255) NOT NULL, adresse_club VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipes (id INT AUTO_INCREMENT NOT NULL, nom_equipe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueurs (id INT AUTO_INCREMENT NOT NULL, club_joueur_id INT DEFAULT NULL, equipe_joueur_id INT DEFAULT NULL, nom_joueur VARCHAR(255) NOT NULL, prenom_joueur VARCHAR(255) NOT NULL, photo_joueur VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, INDEX IDX_F0FD889D6EB778A (club_joueur_id), INDEX IDX_F0FD889DF593B297 (equipe_joueur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE joueurs ADD CONSTRAINT FK_F0FD889D6EB778A FOREIGN KEY (club_joueur_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE joueurs ADD CONSTRAINT FK_F0FD889DF593B297 FOREIGN KEY (equipe_joueur_id) REFERENCES equipes (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueurs DROP FOREIGN KEY FK_F0FD889D6EB778A');
        $this->addSql('ALTER TABLE joueurs DROP FOREIGN KEY FK_F0FD889DF593B297');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE equipes');
        $this->addSql('DROP TABLE joueurs');
    }
}
