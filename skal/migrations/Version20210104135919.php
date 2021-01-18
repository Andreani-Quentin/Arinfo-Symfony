<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210104135919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE id_restaurant (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture ADD id_bar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F892EAD90D7 FOREIGN KEY (id_bar_id) REFERENCES bar (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F892EAD90D7 ON picture (id_bar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE id_restaurant');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F892EAD90D7');
        $this->addSql('DROP INDEX IDX_16DB4F892EAD90D7 ON picture');
        $this->addSql('ALTER TABLE picture DROP id_bar_id');
    }
}
