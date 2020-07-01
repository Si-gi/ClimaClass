<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701090922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Contacts (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, contact_id INT DEFAULT NULL, INDEX IDX_CA367725A76ED395 (user_id), INDEX IDX_CA367725E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Contacts ADD CONSTRAINT FK_CA367725A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE Contacts ADD CONSTRAINT FK_CA367725E7A1254A FOREIGN KEY (contact_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE measure DROP FOREIGN KEY FK_800719256278D5A8');
        $this->addSql('ALTER TABLE measure DROP FOREIGN KEY FK_80071925B72EAA8E');
        $this->addSql('DROP INDEX IDX_800719256278D5A8 ON measure');
        $this->addSql('DROP INDEX IDX_80071925B72EAA8E ON measure');
        $this->addSql('ALTER TABLE measure DROP id_publication, DROP classroom_id');
        $this->addSql('ALTER TABLE private_message ADD receiver INT DEFAULT NULL, ADD sender INT DEFAULT NULL, ADD sendAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE private_message ADD CONSTRAINT FK_4744FC9B3DB88C96 FOREIGN KEY (receiver) REFERENCES user (id)');
        $this->addSql('ALTER TABLE private_message ADD CONSTRAINT FK_4744FC9B5F004ACF FOREIGN KEY (sender) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4744FC9B3DB88C96 ON private_message (receiver)');
        $this->addSql('CREATE INDEX IDX_4744FC9B5F004ACF ON private_message (sender)');
        $this->addSql('ALTER TABLE public_message DROP FOREIGN KEY FK_ED636FCD4014C370');
        $this->addSql('ALTER TABLE public_message DROP FOREIGN KEY FK_ED636FCD74E832F2');
        $this->addSql('DROP INDEX IDX_ED636FCD4014C370 ON public_message');
        $this->addSql('DROP INDEX IDX_ED636FCD74E832F2 ON public_message');
        $this->addSql('ALTER TABLE public_message ADD receiver INT DEFAULT NULL, ADD sender INT DEFAULT NULL, ADD sendAt DATETIME DEFAULT NULL, DROP idClassEmeteur, DROP idClasseDestinataire');
        $this->addSql('ALTER TABLE public_message ADD CONSTRAINT FK_ED636FCD3DB88C96 FOREIGN KEY (receiver) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE public_message ADD CONSTRAINT FK_ED636FCD5F004ACF FOREIGN KEY (sender) REFERENCES classroom (id)');
        $this->addSql('CREATE INDEX IDX_ED636FCD3DB88C96 ON public_message (receiver)');
        $this->addSql('CREATE INDEX IDX_ED636FCD5F004ACF ON public_message (sender)');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67796B3CA4B');
        $this->addSql('DROP INDEX IDX_AF3C67796B3CA4B ON publication');
        $this->addSql('ALTER TABLE publication CHANGE id_user measure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67795DA37D00 FOREIGN KEY (measure_id) REFERENCES measure (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF3C67795DA37D00 ON publication (measure_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Contacts');
        $this->addSql('ALTER TABLE measure ADD id_publication INT DEFAULT NULL, ADD classroom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE measure ADD CONSTRAINT FK_800719256278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE measure ADD CONSTRAINT FK_80071925B72EAA8E FOREIGN KEY (id_publication) REFERENCES publication (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_800719256278D5A8 ON measure (classroom_id)');
        $this->addSql('CREATE INDEX IDX_80071925B72EAA8E ON measure (id_publication)');
        $this->addSql('ALTER TABLE private_message DROP FOREIGN KEY FK_4744FC9B3DB88C96');
        $this->addSql('ALTER TABLE private_message DROP FOREIGN KEY FK_4744FC9B5F004ACF');
        $this->addSql('DROP INDEX IDX_4744FC9B3DB88C96 ON private_message');
        $this->addSql('DROP INDEX IDX_4744FC9B5F004ACF ON private_message');
        $this->addSql('ALTER TABLE private_message DROP receiver, DROP sender, DROP sendAt');
        $this->addSql('ALTER TABLE public_message DROP FOREIGN KEY FK_ED636FCD3DB88C96');
        $this->addSql('ALTER TABLE public_message DROP FOREIGN KEY FK_ED636FCD5F004ACF');
        $this->addSql('DROP INDEX IDX_ED636FCD3DB88C96 ON public_message');
        $this->addSql('DROP INDEX IDX_ED636FCD5F004ACF ON public_message');
        $this->addSql('ALTER TABLE public_message ADD idClassEmeteur INT DEFAULT NULL, ADD idClasseDestinataire INT DEFAULT NULL, DROP receiver, DROP sender, DROP sendAt');
        $this->addSql('ALTER TABLE public_message ADD CONSTRAINT FK_ED636FCD4014C370 FOREIGN KEY (idClassEmeteur) REFERENCES classroom (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE public_message ADD CONSTRAINT FK_ED636FCD74E832F2 FOREIGN KEY (idClasseDestinataire) REFERENCES classroom (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_ED636FCD4014C370 ON public_message (idClassEmeteur)');
        $this->addSql('CREATE INDEX IDX_ED636FCD74E832F2 ON public_message (idClasseDestinataire)');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67795DA37D00');
        $this->addSql('DROP INDEX UNIQ_AF3C67795DA37D00 ON publication');
        $this->addSql('ALTER TABLE publication CHANGE measure_id id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67796B3CA4B FOREIGN KEY (id_user) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AF3C67796B3CA4B ON publication (id_user)');
    }
}
