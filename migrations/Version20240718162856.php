<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718162856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evc_category_translation ADD category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evc_category_translation ADD CONSTRAINT FK_FCE184F79777D11E FOREIGN KEY (category_id_id) REFERENCES evc_category (id)');
        $this->addSql('CREATE INDEX IDX_FCE184F79777D11E ON evc_category_translation (category_id_id)');
       /* $this->addSql('ALTER TABLE evc_product_translation DROP FOREIGN KEY FK_B4007B1FF91A0F34');
        $this->addSql('DROP INDEX idx_b4007b1ff91a0f34 ON evc_product_translation');
        $this->addSql('CREATE INDEX IDX_4AF58A9F91A0F34 ON evc_product_translation (prod_id_id)');
        $this->addSql('ALTER TABLE evc_product_translation ADD CONSTRAINT FK_B4007B1FF91A0F34 FOREIGN KEY (prod_id_id) REFERENCES evc_product (id)');*/
    }

    public function down(Schema $schema): void
    {
        
    }
}
