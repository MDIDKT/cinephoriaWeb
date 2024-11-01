<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241027171428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE films (id INT AUTO_INCREMENT NOT NULL, cinemas_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, age_minimum INT NOT NULL, coup_de_coeur TINYINT(1) NOT NULL, note DOUBLE PRECISION NOT NULL, qualite VARCHAR(255) NOT NULL, INDEX IDX_CEECCA51C5C76018 (cinemas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE films ADD CONSTRAINT FK_CEECCA51C5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id)');
        $this->addSql('ALTER TABLE reservations ADD films_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239939610EE FOREIGN KEY (films_id) REFERENCES films (id)');
        $this->addSql('CREATE INDEX IDX_4DA239939610EE ON reservations (films_id)');
        $this->addSql('ALTER TABLE seance ADD films_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E939610EE FOREIGN KEY (films_id) REFERENCES films (id)');
        $this->addSql('CREATE INDEX IDX_DF7DFD0E939610EE ON seance (films_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239939610EE');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E939610EE');
        $this->addSql('ALTER TABLE films DROP FOREIGN KEY FK_CEECCA51C5C76018');
        $this->addSql('DROP TABLE films');
        $this->addSql('DROP INDEX IDX_4DA239939610EE ON reservations');
        $this->addSql('ALTER TABLE reservations DROP films_id');
        $this->addSql('DROP INDEX IDX_DF7DFD0E939610EE ON seance');
        $this->addSql('ALTER TABLE seance DROP films_id');
    }
}
