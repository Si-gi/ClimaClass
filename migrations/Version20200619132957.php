<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200619132957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, year VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, mime_type VARCHAR(255) NOT NULL, file_size INT NOT NULL, entity VARCHAR(255) NOT NULL, id_entity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication_type_donnee (publication_id INT NOT NULL, type_donnee_id INT NOT NULL, INDEX IDX_7193AECF38B217A7 (publication_id), INDEX IDX_7193AECF77D68DBD (type_donnee_id), PRIMARY KEY(publication_id, type_donnee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) DEFAULT NULL, localisation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_donnee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, data VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE publication_type_donnee ADD CONSTRAINT FK_7193AECF38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication_type_donnee ADD CONSTRAINT FK_7193AECF77D68DBD FOREIGN KEY (type_donnee_id) REFERENCES type_donnee (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication_type_donnee DROP FOREIGN KEY FK_7193AECF38B217A7');
        $this->addSql('ALTER TABLE publication_type_donnee DROP FOREIGN KEY FK_7193AECF77D68DBD');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE publication_type_donnee');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE type_donnee');
    }
}
