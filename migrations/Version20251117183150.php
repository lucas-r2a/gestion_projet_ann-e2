<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251117183150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lier (id INT AUTO_INCREMENT NOT NULL, id_team_id INT NOT NULL, id_projet_id INT NOT NULL, INDEX IDX_B133E8FAF7F171DE (id_team_id), INDEX IDX_B133E8FA80F43E55 (id_projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FAF7F171DE FOREIGN KEY (id_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FA80F43E55 FOREIGN KEY (id_projet_id) REFERENCES projet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lier DROP FOREIGN KEY FK_B133E8FAF7F171DE');
        $this->addSql('ALTER TABLE lier DROP FOREIGN KEY FK_B133E8FA80F43E55');
        $this->addSql('DROP TABLE lier');
    }
}
