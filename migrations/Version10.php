<?php

// migrations/VersionXXXXXXXXXXXXXX.php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class VersionXXXXXXXXXXXXXX extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add comp_url column to evc_component table';
    }

    public function up(Schema $schema): void
    {
        
    }

    public function down(Schema $schema): void
    {
        
    }
}
