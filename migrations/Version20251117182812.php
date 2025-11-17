<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251117182812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE composer (id INT AUTO_INCREMENT NOT NULL, id_team_id INT NOT NULL, id_user_id INT NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_987306D8F7F171DE (id_team_id), INDEX IDX_987306D879F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8F7F171DE FOREIGN KEY (id_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D879F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8F7F171DE');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D879F37AE5');
        $this->addSql('DROP TABLE composer');
    }
}
