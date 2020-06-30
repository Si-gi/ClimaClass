<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200630143429 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE private_message (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE public_message (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, idClassEmeteur INT DEFAULT NULL, idClasseDestinataire INT DEFAULT NULL, INDEX IDX_ED636FCD4014C370 (idClassEmeteur), INDEX IDX_ED636FCD74E832F2 (idClasseDestinataire), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE public_message ADD CONSTRAINT FK_ED636FCD4014C370 FOREIGN KEY (idClassEmeteur) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE public_message ADD CONSTRAINT FK_ED636FCD74E832F2 FOREIGN KEY (idClasseDestinataire) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE classroom ADD school_id INT NOT NULL');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309DC32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_497D309DC32A47EE ON classroom (school_id)');
        $this->addSql('ALTER TABLE measure ADD classroom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE measure ADD CONSTRAINT FK_800719256278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('CREATE INDEX IDX_800719256278D5A8 ON measure (classroom_id)');
        $this->addSql('ALTER TABLE publication ADD classroom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67796278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('CREATE INDEX IDX_AF3C67796278D5A8 ON publication (classroom_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE private_message');
        $this->addSql('DROP TABLE public_message');
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309DC32A47EE');
        $this->addSql('DROP INDEX IDX_497D309DC32A47EE ON classroom');
        $this->addSql('ALTER TABLE classroom DROP school_id');
        $this->addSql('ALTER TABLE measure DROP FOREIGN KEY FK_800719256278D5A8');
        $this->addSql('DROP INDEX IDX_800719256278D5A8 ON measure');
        $this->addSql('ALTER TABLE measure DROP classroom_id');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67796278D5A8');
        $this->addSql('DROP INDEX IDX_AF3C67796278D5A8 ON publication');
        $this->addSql('ALTER TABLE publication DROP classroom_id');
    }
}
