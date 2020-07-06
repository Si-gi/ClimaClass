<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701174839 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP entity, CHANGE id_entity publication_id INT NOT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361038B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_8C9F361038B217A7 ON file (publication_id)');
        $this->addSql('ALTER TABLE measure DROP FOREIGN KEY FK_800719256278D5A8');
        $this->addSql('DROP INDEX IDX_800719256278D5A8 ON measure');
        $this->addSql('ALTER TABLE measure DROP classroom_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361038B217A7');
        $this->addSql('DROP INDEX IDX_8C9F361038B217A7 ON file');
        $this->addSql('ALTER TABLE file ADD entity VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE publication_id id_entity INT NOT NULL');
        $this->addSql('ALTER TABLE measure ADD classroom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE measure ADD CONSTRAINT FK_800719256278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('CREATE INDEX IDX_800719256278D5A8 ON measure (classroom_id)');
    }
}
