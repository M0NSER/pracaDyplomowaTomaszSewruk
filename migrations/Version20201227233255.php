<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201227233255 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_in_tournament CHANGE id_tournament id_tournament INT DEFAULT NULL, CHANGE id_tournament_user id_tournament_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY reset_password_request_ibfk_1');
        $this->addSql('ALTER TABLE reset_password_request ADD selector VARCHAR(20) NOT NULL, ADD hashed_token VARCHAR(100) NOT NULL, ADD requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE expires_at expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP INDEX fk_reset_password_request_user ON reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748A6B3CA4B ON reset_password_request (id_user)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT reset_password_request_ibfk_1 FOREIGN KEY (id_user) REFERENCES user (id_user) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE tournament CHANGE is_public is_public TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE tournament_code CHANGE id_tournament id_tournament INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tournament_user CHANGE id_tournament id_tournament INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE tournament_user_type tournament_user_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', CHANGE is_verified is_verified TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE vote CHANGE id_tournament_user id_tournament_user INT DEFAULT NULL, CHANGE id_tournament id_tournament INT DEFAULT NULL, CHANGE id_option_in_tournament id_option_in_tournament INT DEFAULT NULL, CHANGE is_selected_by_promoter is_selected_by_promoter TINYINT(1) NOT NULL, CHANGE priority priority INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_in_tournament CHANGE id_tournament_user id_tournament_user INT NOT NULL, CHANGE id_tournament id_tournament INT NOT NULL');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748A6B3CA4B');
        $this->addSql('ALTER TABLE reset_password_request DROP selector, DROP hashed_token, DROP requested_at, CHANGE expires_at expires_at DATETIME NOT NULL');
        $this->addSql('DROP INDEX idx_7ce748a6b3ca4b ON reset_password_request');
        $this->addSql('CREATE INDEX fk_reset_password_request_user ON reset_password_request (id_user)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748A6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE tournament CHANGE is_public is_public TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE tournament_code CHANGE id_tournament id_tournament INT NOT NULL');
        $this->addSql('ALTER TABLE tournament_user CHANGE id_tournament id_tournament INT NOT NULL, CHANGE id_user id_user INT NOT NULL, CHANGE tournament_user_type tournament_user_type VARCHAR(63) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE is_verified is_verified TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE vote CHANGE id_option_in_tournament id_option_in_tournament INT NOT NULL, CHANGE id_tournament_user id_tournament_user INT NOT NULL, CHANGE id_tournament id_tournament INT NOT NULL, CHANGE is_selected_by_promoter is_selected_by_promoter TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE priority priority INT DEFAULT 0 NOT NULL');
    }
}
