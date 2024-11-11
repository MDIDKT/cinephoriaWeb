<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241110150339 extends AbstractMigration
{
    public function getDescription (): string
    {
        return '';
    }

    public function up (Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql ('ALTER TABLE reservations ADD user_id INT DEFAULT NULL, ADD status VARCHAR(255) DEFAULT NULL, DROP type_pmr');
        $this->addSql ('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql ('CREATE INDEX IDX_4DA239A76ED395 ON reservations (user_id)');
        $this->addSql ('ALTER TABLE salles ADD type_qualite VARCHAR(255) DEFAULT NULL');
        $this->addSql ('ALTER TABLE seance ADD salle_id INT DEFAULT NULL, ADD cinemas_id INT DEFAULT NULL, ADD heure_fin DATETIME DEFAULT NULL, ADD qualite VARCHAR(255) DEFAULT NULL');
        $this->addSql ('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EDC304035 FOREIGN KEY (salle_id) REFERENCES salles (id)');
        $this->addSql ('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EC5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id)');
        $this->addSql ('CREATE INDEX IDX_DF7DFD0EDC304035 ON seance (salle_id)');
        $this->addSql ('CREATE INDEX IDX_DF7DFD0EC5C76018 ON seance (cinemas_id)');
    }

    public function down (Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql ('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql ('DROP INDEX IDX_4DA239A76ED395 ON reservations');
        $this->addSql ('ALTER TABLE reservations ADD type_pmr TINYINT(1) NOT NULL, DROP user_id, DROP status');
        $this->addSql ('ALTER TABLE salles DROP type_qualite');
        $this->addSql ('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EDC304035');
        $this->addSql ('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0EC5C76018');
        $this->addSql ('DROP INDEX IDX_DF7DFD0EDC304035 ON seance');
        $this->addSql ('DROP INDEX IDX_DF7DFD0EC5C76018 ON seance');
        $this->addSql ('ALTER TABLE seance DROP salle_id, DROP cinemas_id, DROP heure_fin, DROP qualite');
    }
}
