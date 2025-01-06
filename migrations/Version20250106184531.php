<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250106184531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0A76ED395');
        $this->addSql('DROP INDEX IDX_8F91ABF0A76ED395 ON avis');
        $this->addSql('ALTER TABLE avis DROP user_id');
        $this->addSql('ALTER TABLE incidents DROP FOREIGN KEY FK_E65135D0F971F91F');
        $this->addSql('DROP INDEX IDX_E65135D0F971F91F ON incidents');
        $this->addSql('ALTER TABLE incidents DROP employes_id');
        $this->addSql('DROP INDEX IDX_4DA239A76ED395 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0A76ED395 ON avis (user_id)');
        $this->addSql('ALTER TABLE reservations ADD user_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_4DA239A76ED395 ON reservations (user_id)');
        $this->addSql('ALTER TABLE incidents ADD employes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D0F971F91F FOREIGN KEY (employes_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E65135D0F971F91F ON incidents (employes_id)');
    }
}
