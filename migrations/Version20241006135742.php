<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241006135742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cinemas (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, adresse LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cinemas_films (cinemas_id INT NOT NULL, films_id INT NOT NULL, INDEX IDX_A5215F8FC5C76018 (cinemas_id), INDEX IDX_A5215F8F939610EE (films_id), PRIMARY KEY(cinemas_id, films_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cinemas_films ADD CONSTRAINT FK_A5215F8FC5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cinemas_films ADD CONSTRAINT FK_A5215F8F939610EE FOREIGN KEY (films_id) REFERENCES films (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cinemas_films DROP FOREIGN KEY FK_A5215F8FC5C76018');
        $this->addSql('ALTER TABLE cinemas_films DROP FOREIGN KEY FK_A5215F8F939610EE');
        $this->addSql('DROP TABLE cinemas');
        $this->addSql('DROP TABLE cinemas_films');
    }
}
