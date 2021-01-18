<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210104144244 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bar_id INT DEFAULT NULL, message LONGTEXT NOT NULL, rating INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_794381C6A76ED395 (user_id), INDEX IDX_794381C689A253A (bar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C689A253A FOREIGN KEY (bar_id) REFERENCES bar (id)');
        $this->addSql('ALTER TABLE bar ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bar ADD CONSTRAINT FK_76FF8CAAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_76FF8CAAA76ED395 ON bar (user_id)');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE review');
        $this->addSql('ALTER TABLE bar DROP FOREIGN KEY FK_76FF8CAAA76ED395');
        $this->addSql('DROP INDEX IDX_76FF8CAAA76ED395 ON bar');
        $this->addSql('ALTER TABLE bar DROP user_id');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname');
    }
}
