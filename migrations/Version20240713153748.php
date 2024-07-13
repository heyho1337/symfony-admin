<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713153748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evc_product_evc_category (evc_product_id INT NOT NULL, evc_category_id INT NOT NULL, INDEX IDX_5B511323D150A2EC (evc_product_id), INDEX IDX_5B51132330D05F9F (evc_category_id), PRIMARY KEY(evc_product_id, evc_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evc_product_evc_category ADD CONSTRAINT FK_5B511323D150A2EC FOREIGN KEY (evc_product_id) REFERENCES evc_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evc_product_evc_category ADD CONSTRAINT FK_5B51132330D05F9F FOREIGN KEY (evc_category_id) REFERENCES evc_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evc_category DROP category_id');
        $this->addSql('ALTER TABLE evc_component CHANGE position position INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE evc_product CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE prod_name prod_name VARCHAR(75) NOT NULL, CHANGE prod_active prod_active INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE prod_price prod_price DOUBLE PRECISION NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_169DF991989D9B62 ON evc_product (slug)');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evc_product_evc_category DROP FOREIGN KEY FK_5B511323D150A2EC');
        $this->addSql('ALTER TABLE evc_product_evc_category DROP FOREIGN KEY FK_5B51132330D05F9F');
        $this->addSql('DROP TABLE evc_product_evc_category');
        $this->addSql('ALTER TABLE evc_category ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE evc_component CHANGE position position INT DEFAULT 0 NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('DROP INDEX UNIQ_169DF991989D9B62 ON evc_product');
        $this->addSql('ALTER TABLE evc_product CHANGE id id INT AUTO_INCREMENT NOT NULL COMMENT \'hidden\', CHANGE prod_name prod_name VARCHAR(75) NOT NULL COMMENT \'text\', CHANGE prod_active prod_active INT NOT NULL COMMENT \'active\', CHANGE prod_price prod_price DOUBLE PRECISION NOT NULL COMMENT \'price\', CHANGE created_at created_at DATETIME NOT NULL COMMENT \'datetime\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'datetime\'');
        $this->addSql('ALTER TABLE `user` CHANGE is_verified is_verified TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
