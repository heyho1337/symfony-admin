<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713070934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evc_component CHANGE comp_sorrend comp_sorrend INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE evc_product ADD slug VARCHAR(100) NOT NULL, DROP prod_alias, CHANGE prod_id prod_id INT AUTO_INCREMENT NOT NULL, CHANGE prod_name prod_name VARCHAR(75) NOT NULL, CHANGE prod_active prod_active INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE prod_price prod_price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE is_verified is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evc_component CHANGE comp_sorrend comp_sorrend INT DEFAULT 0 NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE evc_product ADD prod_alias VARCHAR(75) NOT NULL COMMENT \'text\', DROP slug, CHANGE prod_id prod_id INT NOT NULL COMMENT \'hidden\', CHANGE prod_name prod_name VARCHAR(75) NOT NULL COMMENT \'text\', CHANGE prod_active prod_active INT NOT NULL COMMENT \'active\', CHANGE prod_price prod_price DOUBLE PRECISION NOT NULL COMMENT \'price\', CHANGE created_at created_at DATETIME NOT NULL COMMENT \'datetime\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'datetime\'');
        $this->addSql('ALTER TABLE `user` CHANGE is_verified is_verified TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
