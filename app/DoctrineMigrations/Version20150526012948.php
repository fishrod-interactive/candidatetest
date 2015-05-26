<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150526012948 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM guest_guest;');
        $this->addSql('CREATE TABLE media_photo (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE guest_guest CHANGE photo photo INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest_guest ADD CONSTRAINT FK_B9490D2114B78418 FOREIGN KEY (photo) REFERENCES media_photo (id)');
        $this->addSql('CREATE INDEX IDX_B9490D2114B78418 ON guest_guest (photo)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guest_guest DROP FOREIGN KEY FK_B9490D2114B78418');
        $this->addSql('DROP TABLE media_photo');
        $this->addSql('DROP INDEX IDX_B9490D2114B78418 ON guest_guest');
        $this->addSql('DELETE FROM guest_guest;');
        $this->addSql('ALTER TABLE guest_guest CHANGE photo photo VARCHAR(255) NOT NULL');
    }
}
