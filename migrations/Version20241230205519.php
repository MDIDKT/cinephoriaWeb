<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241230205519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cinemas_films (cinemas_id INT NOT NULL, films_id INT NOT NULL, INDEX IDX_A5215F8FC5C76018 (cinemas_id), INDEX IDX_A5215F8F939610EE (films_id), PRIMARY KEY(cinemas_id, films_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cinemas_films ADD CONSTRAINT FK_A5215F8FC5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cinemas_films ADD CONSTRAINT FK_A5215F8F939610EE FOREIGN KEY (films_id) REFERENCES films (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cinemas ADD horaire VARCHAR(255) DEFAULT NULL, CHANGE adresse adresse LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE films ADD qualite VARCHAR(255) NOT NULL, ADD image_size INT DEFAULT NULL, DROP updated_at, CHANGE image image_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cinemas_films DROP FOREIGN KEY FK_A5215F8FC5C76018');
        $this->addSql('ALTER TABLE cinemas_films DROP FOREIGN KEY FK_A5215F8F939610EE');
        $this->addSql('DROP TABLE cinemas_films');
        $this->addSql('ALTER TABLE cinemas DROP horaire, CHANGE adresse adresse VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE films ADD updated_at DATETIME DEFAULT NULL, DROP qualite, DROP image_size, CHANGE image_name image VARCHAR(255) DEFAULT NULL');
    }
}
