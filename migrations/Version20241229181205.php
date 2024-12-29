<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241229181205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE films_cinemas (films_id INT NOT NULL, cinemas_id INT NOT NULL, INDEX IDX_65DC6439939610EE (films_id), INDEX IDX_65DC6439C5C76018 (cinemas_id), PRIMARY KEY(films_id, cinemas_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE films_cinemas ADD CONSTRAINT FK_65DC6439939610EE FOREIGN KEY (films_id) REFERENCES films (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE films_cinemas ADD CONSTRAINT FK_65DC6439C5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE films_cinemas DROP FOREIGN KEY FK_65DC6439939610EE');
        $this->addSql('ALTER TABLE films_cinemas DROP FOREIGN KEY FK_65DC6439C5C76018');
        $this->addSql('DROP TABLE films_cinemas');
    }
}
