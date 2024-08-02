<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801065937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` CHANGE roles roles JSON NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE evc_product_evc_category DROP FOREIGN KEY FK_5B511323D150A2EC');
        $this->addSql('ALTER TABLE evc_product_evc_category DROP FOREIGN KEY FK_5B51132330D05F9F');
        $this->addSql('DROP INDEX UNIQ_169DF991BFCC60B1 ON evc_product');
        $this->addSql('ALTER TABLE evc_product DROP prod_image, CHANGE prod_name prod_name LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE prod_url prod_url LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE prod_description prod_description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`');
    }
}
