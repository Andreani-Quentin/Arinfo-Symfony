<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210104140303 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bar ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bar ADD CONSTRAINT FK_76FF8CAA8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_76FF8CAA8BAC62AF ON bar (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pictures');
        $this->addSql('ALTER TABLE bar DROP FOREIGN KEY FK_76FF8CAA8BAC62AF');
        $this->addSql('DROP INDEX IDX_76FF8CAA8BAC62AF ON bar');
        $this->addSql('ALTER TABLE bar DROP city_id');
    }
}
