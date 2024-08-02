<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801074038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evc_category ADD category_url JSON NOT NULL, DROP slug, CHANGE category_name category_name JSON NOT NULL, CHANGE category_description category_description JSON DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29E6B2BBD1B4E8F4 ON evc_category (category_url)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_29E6B2BBD1B4E8F4 ON evc_category');
        $this->addSql('ALTER TABLE evc_category ADD slug VARCHAR(100) NOT NULL, DROP category_url, CHANGE category_name category_name VARCHAR(255) NOT NULL, CHANGE category_description category_description LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29E6B2BB989D9B62 ON evc_category (slug)');
        $this->addSql('ALTER TABLE `user` CHANGE roles roles JSON NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE evc_product_evc_category DROP FOREIGN KEY FK_5B511323D150A2EC');
        $this->addSql('ALTER TABLE evc_product_evc_category DROP FOREIGN KEY FK_5B51132330D05F9F');
        $this->addSql('DROP INDEX UNIQ_169DF991BFCC60B1 ON evc_product');
    }
}
