<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170125053613 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE list ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE list ADD CONSTRAINT FK_44C8F818A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_44C8F818A76ED395 ON list (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE list DROP FOREIGN KEY FK_44C8F818A76ED395');
        $this->addSql('DROP INDEX IDX_44C8F818A76ED395 ON list');
        $this->addSql('ALTER TABLE list DROP user_id');
    }
}
