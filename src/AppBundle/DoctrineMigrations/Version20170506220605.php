<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170506220605 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cm_tasks (id INT AUTO_INCREMENT NOT NULL, assigned_to_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, due_at DATETIME DEFAULT NULL, priority VARCHAR(255) NOT NULL, INDEX IDX_BA857DBCF4BD7827 (assigned_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cm_tasks ADD CONSTRAINT FK_BA857DBCF4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES cm_users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cm_projects ADD budget DOUBLE PRECISION NOT NULL, CHANGE starts_at starts_at DATETIME DEFAULT NULL, CHANGE ends_at ends_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE INDEX DATES_IDX ON cm_projects (starts_at, ends_at)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cm_tasks');
        $this->addSql('DROP INDEX DATES_IDX ON cm_projects');
        $this->addSql('ALTER TABLE cm_projects DROP budget, CHANGE starts_at starts_at DATETIME NOT NULL, CHANGE ends_at ends_at DATETIME NOT NULL');
    }
}
