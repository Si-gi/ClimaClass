<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623113121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE measure (id INT AUTO_INCREMENT NOT NULL, id_publication INT DEFAULT NULL, temperature DOUBLE PRECISION DEFAULT NULL, wind_speed DOUBLE PRECISION DEFAULT NULL, wind_direction INT DEFAULT NULL, rain_level INT DEFAULT NULL, measurement_date DATETIME DEFAULT NULL, rain_measure_duration INT DEFAULT NULL, INDEX IDX_80071925B72EAA8E (id_publication), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE measure ADD CONSTRAINT FK_80071925B72EAA8E FOREIGN KEY (id_publication) REFERENCES publication (id)');
        $this->addSql('DROP TABLE publication_type_donnee');
        $this->addSql('ALTER TABLE fos_user ADD establishment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD id_user INT DEFAULT NULL, ADD title VARCHAR(255) NOT NULL, ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67796B3CA4B FOREIGN KEY (id_user) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_AF3C67796B3CA4B ON publication (id_user)');
        $this->addSql('ALTER TABLE school ADD latitude DOUBLE PRECISION DEFAULT NULL, ADD longitude DOUBLE PRECISION DEFAULT NULL, DROP localisation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE publication_type_donnee (publication_id INT NOT NULL, type_donnee_id INT NOT NULL, INDEX IDX_7193AECF38B217A7 (publication_id), INDEX IDX_7193AECF77D68DBD (type_donnee_id), PRIMARY KEY(publication_id, type_donnee_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE publication_type_donnee ADD CONSTRAINT FK_7193AECF38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication_type_donnee ADD CONSTRAINT FK_7193AECF77D68DBD FOREIGN KEY (type_donnee_id) REFERENCES type_donnee (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE measure');
        $this->addSql('ALTER TABLE fos_user DROP establishment');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67796B3CA4B');
        $this->addSql('DROP INDEX IDX_AF3C67796B3CA4B ON publication');
        $this->addSql('ALTER TABLE publication DROP id_user, DROP title, DROP content');
        $this->addSql('ALTER TABLE school ADD localisation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP latitude, DROP longitude');
    }
}
