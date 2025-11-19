<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251119132306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_9387207580F43E55');
        $this->addSql('DROP INDEX IDX_9387207580F43E55 ON tache');
        $this->addSql('ALTER TABLE tache CHANGE id_projet_id projet_id INT NOT NULL');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_93872075C18272 ON tache (projet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075C18272');
        $this->addSql('DROP INDEX IDX_93872075C18272 ON tache');
        $this->addSql('ALTER TABLE tache CHANGE projet_id id_projet_id INT NOT NULL');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207580F43E55 FOREIGN KEY (id_projet_id) REFERENCES projet (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9387207580F43E55 ON tache (id_projet_id)');
    }
}
