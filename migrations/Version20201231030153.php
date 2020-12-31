<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201231030153 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY fk_votes_tournament_users1');
        $this->addSql('DROP INDEX fk_votes_tournament_users1_idx ON vote');
        $this->addSql('ALTER TABLE vote CHANGE id_tournament_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('CREATE INDEX fk_votes_users1_idx ON vote (id_user)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646B3CA4B');
        $this->addSql('DROP INDEX fk_votes_users1_idx ON vote');
        $this->addSql('ALTER TABLE vote CHANGE id_user id_tournament_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT fk_votes_tournament_users1 FOREIGN KEY (id_tournament_user) REFERENCES tournament_user (id_tournament_user) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX fk_votes_tournament_users1_idx ON vote (id_tournament_user)');
    }
}
