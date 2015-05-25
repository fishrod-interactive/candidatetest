<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150525145527 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE guest_guest (id INT AUTO_INCREMENT NOT NULL, wedding_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, created DATETIME NOT NULL, INDEX IDX_B9490D21FCBBB0ED (wedding_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE guest_guest ADD CONSTRAINT FK_B9490D21FCBBB0ED FOREIGN KEY (wedding_id) REFERENCES wedding_wedding (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE guest_guest');
    }
}
