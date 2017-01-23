<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170117000148 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE list (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_product (list_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_F05D9A03DAE168B (list_id), UNIQUE INDEX UNIQ_F05D9A04584665A (product_id), PRIMARY KEY(list_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE list_product ADD CONSTRAINT FK_F05D9A03DAE168B FOREIGN KEY (list_id) REFERENCES list (id)');
        $this->addSql('ALTER TABLE list_product ADD CONSTRAINT FK_F05D9A04584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE list_product DROP FOREIGN KEY FK_F05D9A03DAE168B');
        $this->addSql('DROP TABLE list');
        $this->addSql('DROP TABLE list_product');
    }
}
