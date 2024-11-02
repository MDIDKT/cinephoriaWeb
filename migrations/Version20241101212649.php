<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101212649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0939610EE');
        $this->addSql('DROP INDEX IDX_8F91ABF0939610EE ON avis');
        $this->addSql('ALTER TABLE avis CHANGE commentaire commentaire LONGTEXT DEFAULT NULL, CHANGE note note INT NOT NULL, CHANGE films_id film_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0567F5183 FOREIGN KEY (film_id) REFERENCES films (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0567F5183 ON avis (film_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0567F5183');
        $this->addSql('DROP INDEX IDX_8F91ABF0567F5183 ON avis');
        $this->addSql('ALTER TABLE avis CHANGE commentaire commentaire LONGTEXT NOT NULL, CHANGE note note INT DEFAULT NULL, CHANGE film_id films_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0939610EE FOREIGN KEY (films_id) REFERENCES films (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0939610EE ON avis (films_id)');
    }
}
