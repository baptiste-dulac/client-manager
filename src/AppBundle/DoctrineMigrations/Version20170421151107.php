<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170421151107 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cm_clients ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cm_clients ADD CONSTRAINT FK_65D4A196A76ED395 FOREIGN KEY (user_id) REFERENCES cm_users (id)');
        $this->addSql('CREATE INDEX IDX_65D4A196A76ED395 ON cm_clients (user_id)');
        $this->addSql('ALTER TABLE cm_projects ADD starts_at DATETIME NOT NULL, ADD ends_at DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cm_clients DROP FOREIGN KEY FK_65D4A196A76ED395');
        $this->addSql('DROP INDEX IDX_65D4A196A76ED395 ON cm_clients');
        $this->addSql('ALTER TABLE cm_clients DROP user_id');
        $this->addSql('ALTER TABLE cm_projects DROP starts_at, DROP ends_at');
    }
}
