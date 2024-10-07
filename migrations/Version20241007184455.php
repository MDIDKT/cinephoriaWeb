<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007184455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, cinemas_id INT DEFAULT NULL, films_id INT DEFAULT NULL, seances_id INT DEFAULT NULL, nombre_places INT NOT NULL, type_pmr TINYINT(1) NOT NULL, prix_total DOUBLE PRECISION NOT NULL, INDEX IDX_4DA239C5C76018 (cinemas_id), INDEX IDX_4DA239939610EE (films_id), INDEX IDX_4DA23910F09302 (seances_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239C5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239939610EE FOREIGN KEY (films_id) REFERENCES films (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23910F09302 FOREIGN KEY (seances_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE salles DROP FOREIGN KEY FK_799D45AAB4CB84B6');
        $this->addSql('DROP INDEX IDX_799D45AAB4CB84B6 ON salles');
        $this->addSql('ALTER TABLE salles DROP cinema_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239C5C76018');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239939610EE');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23910F09302');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('ALTER TABLE salles ADD cinema_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salles ADD CONSTRAINT FK_799D45AAB4CB84B6 FOREIGN KEY (cinema_id) REFERENCES cinemas (id)');
        $this->addSql('CREATE INDEX IDX_799D45AAB4CB84B6 ON salles (cinema_id)');
    }
}
