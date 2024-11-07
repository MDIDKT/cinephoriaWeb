<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107203347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY avis_ibfk_1');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY seance_ibfk_2');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY seance_ibfk_1');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY avis_ibfk_2');
        $this->addSql('CREATE TABLE cinemas (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, adresse LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE films (id INT AUTO_INCREMENT NOT NULL, cinemas_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, age_minimum INT NOT NULL, coup_de_coeur TINYINT(1) NOT NULL, note DOUBLE PRECISION NOT NULL, qualite VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, INDEX IDX_CEECCA51C5C76018 (cinemas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, cinemas_id INT DEFAULT NULL, seances_id INT DEFAULT NULL, films_id INT DEFAULT NULL, nombre_places INT NOT NULL, type_pmr TINYINT(1) NOT NULL, prix_total DOUBLE PRECISION NOT NULL, INDEX IDX_4DA239C5C76018 (cinemas_id), INDEX IDX_4DA23910F09302 (seances_id), INDEX IDX_4DA239939610EE (films_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salles (id INT AUTO_INCREMENT NOT NULL, numero_salle INT NOT NULL, nombre_siege INT NOT NULL, nombre_siege_pmr INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE films ADD CONSTRAINT FK_CEECCA51C5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239C5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23910F09302 FOREIGN KEY (seances_id) REFERENCES seance (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239939610EE FOREIGN KEY (films_id) REFERENCES films (id)');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY salle_ibfk_1');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY film_ibfk_1');
        $this->addSql('ALTER TABLE film_genre DROP FOREIGN KEY film_genre_ibfk_2');
        $this->addSql('ALTER TABLE film_genre DROP FOREIGN KEY film_genre_ibfk_1');
        $this->addSql('ALTER TABLE qr_code DROP FOREIGN KEY qr_code_ibfk_1');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY incident_ibfk_1');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY incident_ibfk_2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_1');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY reservation_ibfk_2');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE cinema');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE qualite');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE film_genre');
        $this->addSql('DROP TABLE qr_code');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP INDEX utilisateur_id ON avis');
        $this->addSql('ALTER TABLE avis ADD approuve TINYINT(1) NOT NULL, DROP utilisateur_id, DROP createdAt, CHANGE note note INT NOT NULL, CHANGE commentaire commentaire LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0567F5183 FOREIGN KEY (film_id) REFERENCES films (id)');
        $this->addSql('ALTER TABLE avis RENAME INDEX film_id TO IDX_8F91ABF0567F5183');
        $this->addSql('DROP INDEX film_id ON seance');
        $this->addSql('DROP INDEX salle_id ON seance');
        $this->addSql('ALTER TABLE seance ADD films_id INT DEFAULT NULL, ADD heure_debut DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP film_id, DROP salle_id, DROP heureDebut, DROP heureFin, DROP prix, DROP createdAt');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E939610EE FOREIGN KEY (films_id) REFERENCES films (id)');
        $this->addSql('CREATE INDEX IDX_DF7DFD0E939610EE ON seance (films_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0567F5183');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E939610EE');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, motDePasse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, role VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cinema (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, cinema_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, capacite INT NOT NULL, typeSiege VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, INDEX cinema_id (cinema_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE qualite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix NUMERIC(5, 2) NOT NULL, UNIQUE INDEX nom (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, qualite_id INT DEFAULT NULL, affiche VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, ageMinimum INT DEFAULT NULL, coupDeCoeur TINYINT(1) DEFAULT 0, note NUMERIC(2, 1) DEFAULT NULL, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX qualite_id (qualite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, UNIQUE INDEX nom (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE film_genre (film_id INT NOT NULL, genre_id INT NOT NULL, INDEX genre_id (genre_id), INDEX IDX_1A3CCDA8567F5183 (film_id), PRIMARY KEY(film_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE qr_code (id INT AUTO_INCREMENT NOT NULL, reservation_id INT DEFAULT NULL, code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX code (code), INDEX reservation_id (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, salle_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateSignalement DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, status VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'en_cours\' COLLATE `utf8mb4_general_ci`, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX employe_id (employe_id), INDEX salle_id (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, seance_id INT DEFAULT NULL, nombrePlaces INT NOT NULL, prixTotal NUMERIC(5, 2) NOT NULL, status VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'en_attente\' COLLATE `utf8mb4_general_ci`, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX seance_id (seance_id), INDEX utilisateur_id (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT salle_ibfk_1 FOREIGN KEY (cinema_id) REFERENCES cinema (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT film_ibfk_1 FOREIGN KEY (qualite_id) REFERENCES qualite (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE film_genre ADD CONSTRAINT film_genre_ibfk_2 FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_genre ADD CONSTRAINT film_genre_ibfk_1 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE qr_code ADD CONSTRAINT qr_code_ibfk_1 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT incident_ibfk_1 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT incident_ibfk_2 FOREIGN KEY (employe_id) REFERENCES utilisateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_1 FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT reservation_ibfk_2 FOREIGN KEY (seance_id) REFERENCES seance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE films DROP FOREIGN KEY FK_CEECCA51C5C76018');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239C5C76018');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23910F09302');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239939610EE');
        $this->addSql('DROP TABLE cinemas');
        $this->addSql('DROP TABLE films');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE salles');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX IDX_DF7DFD0E939610EE ON seance');
        $this->addSql('ALTER TABLE seance ADD salle_id INT DEFAULT NULL, ADD heureDebut TIME NOT NULL, ADD heureFin TIME NOT NULL, ADD prix NUMERIC(5, 2) NOT NULL, ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP heure_debut, CHANGE films_id film_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT seance_ibfk_1 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT seance_ibfk_2 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX film_id ON seance (film_id)');
        $this->addSql('CREATE INDEX salle_id ON seance (salle_id)');
        $this->addSql('ALTER TABLE avis ADD utilisateur_id INT DEFAULT NULL, ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP approuve, CHANGE commentaire commentaire TEXT DEFAULT NULL, CHANGE note note INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT avis_ibfk_1 FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT avis_ibfk_2 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX utilisateur_id ON avis (utilisateur_id)');
        $this->addSql('ALTER TABLE avis RENAME INDEX idx_8f91abf0567f5183 TO film_id');
    }
}
