<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201231025825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_in_tournament ADD CONSTRAINT FK_60FC74B76B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('CREATE INDEX fk_options_in_tournaments_tournament_users1_idx ON option_in_tournament (id_user)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_in_tournament DROP FOREIGN KEY FK_60FC74B76B3CA4B');
        $this->addSql('DROP INDEX fk_options_in_tournaments_tournament_users1_idx ON option_in_tournament');
    }
}
