<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251117193416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assigner DROP FOREIGN KEY FK_FF4E79CB79F37AE5');
        $this->addSql('ALTER TABLE assigner DROP FOREIGN KEY FK_FF4E79CB82F8B1AC');
        $this->addSql('DROP INDEX IDX_FF4E79CB82F8B1AC ON assigner');
        $this->addSql('DROP INDEX IDX_FF4E79CB79F37AE5 ON assigner');
        $this->addSql('ALTER TABLE assigner ADD tache_id INT NOT NULL, ADD user_id INT NOT NULL, DROP id_tache_id, DROP id_user_id');
        $this->addSql('ALTER TABLE assigner ADD CONSTRAINT FK_FF4E79CBD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE assigner ADD CONSTRAINT FK_FF4E79CBA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_FF4E79CBD2235D39 ON assigner (tache_id)');
        $this->addSql('CREATE INDEX IDX_FF4E79CBA76ED395 ON assigner (user_id)');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D879F37AE5');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8F7F171DE');
        $this->addSql('DROP INDEX IDX_987306D8F7F171DE ON composer');
        $this->addSql('DROP INDEX IDX_987306D879F37AE5 ON composer');
        $this->addSql('ALTER TABLE composer ADD team_id INT NOT NULL, ADD user_id INT NOT NULL, DROP id_team_id, DROP id_user_id');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_987306D8296CD8AE ON composer (team_id)');
        $this->addSql('CREATE INDEX IDX_987306D8A76ED395 ON composer (user_id)');
        $this->addSql('ALTER TABLE lier DROP FOREIGN KEY FK_B133E8FA80F43E55');
        $this->addSql('ALTER TABLE lier DROP FOREIGN KEY FK_B133E8FAF7F171DE');
        $this->addSql('DROP INDEX IDX_B133E8FAF7F171DE ON lier');
        $this->addSql('DROP INDEX IDX_B133E8FA80F43E55 ON lier');
        $this->addSql('ALTER TABLE lier ADD team_id INT NOT NULL, ADD projet_id INT NOT NULL, DROP id_team_id, DROP id_projet_id');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FA296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FAC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_B133E8FA296CD8AE ON lier (team_id)');
        $this->addSql('CREATE INDEX IDX_B133E8FAC18272 ON lier (projet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assigner DROP FOREIGN KEY FK_FF4E79CBD2235D39');
        $this->addSql('ALTER TABLE assigner DROP FOREIGN KEY FK_FF4E79CBA76ED395');
        $this->addSql('DROP INDEX IDX_FF4E79CBD2235D39 ON assigner');
        $this->addSql('DROP INDEX IDX_FF4E79CBA76ED395 ON assigner');
        $this->addSql('ALTER TABLE assigner ADD id_tache_id INT NOT NULL, ADD id_user_id INT NOT NULL, DROP tache_id, DROP user_id');
        $this->addSql('ALTER TABLE assigner ADD CONSTRAINT FK_FF4E79CB79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE assigner ADD CONSTRAINT FK_FF4E79CB82F8B1AC FOREIGN KEY (id_tache_id) REFERENCES tache (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_FF4E79CB82F8B1AC ON assigner (id_tache_id)');
        $this->addSql('CREATE INDEX IDX_FF4E79CB79F37AE5 ON assigner (id_user_id)');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8296CD8AE');
        $this->addSql('ALTER TABLE composer DROP FOREIGN KEY FK_987306D8A76ED395');
        $this->addSql('DROP INDEX IDX_987306D8296CD8AE ON composer');
        $this->addSql('DROP INDEX IDX_987306D8A76ED395 ON composer');
        $this->addSql('ALTER TABLE composer ADD id_team_id INT NOT NULL, ADD id_user_id INT NOT NULL, DROP team_id, DROP user_id');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D879F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT FK_987306D8F7F171DE FOREIGN KEY (id_team_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_987306D8F7F171DE ON composer (id_team_id)');
        $this->addSql('CREATE INDEX IDX_987306D879F37AE5 ON composer (id_user_id)');
        $this->addSql('ALTER TABLE lier DROP FOREIGN KEY FK_B133E8FA296CD8AE');
        $this->addSql('ALTER TABLE lier DROP FOREIGN KEY FK_B133E8FAC18272');
        $this->addSql('DROP INDEX IDX_B133E8FA296CD8AE ON lier');
        $this->addSql('DROP INDEX IDX_B133E8FAC18272 ON lier');
        $this->addSql('ALTER TABLE lier ADD id_team_id INT NOT NULL, ADD id_projet_id INT NOT NULL, DROP team_id, DROP projet_id');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FA80F43E55 FOREIGN KEY (id_projet_id) REFERENCES projet (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FAF7F171DE FOREIGN KEY (id_team_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B133E8FAF7F171DE ON lier (id_team_id)');
        $this->addSql('CREATE INDEX IDX_B133E8FA80F43E55 ON lier (id_projet_id)');
    }
}
