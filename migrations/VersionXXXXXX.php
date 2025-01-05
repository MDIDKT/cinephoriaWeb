<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class VersionXXXXXX extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add updated_at column to films table';
    }

    public function up(Schema $schema): void
    {
        // Vérifier si la colonne 'updated_at' existe avant de l'ajouter
        $this->addSql('ALTER TABLE films ADD IF NOT EXISTS updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // Vérifier si la colonne 'updated_at' existe avant de la supprimer
        $this->addSql('ALTER TABLE films DROP IF EXISTS updated_at');
    }
}
