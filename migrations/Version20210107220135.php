<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210107220135 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE option_in_tournament (id_options_in_tournaments INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, id_tournament INT DEFAULT NULL, title VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, number_of_slots INT DEFAULT NULL, photo_url VARCHAR(255) DEFAULT NULL, create_at DATETIME DEFAULT CURRENT_TIMESTAMP, update_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX fk_options_in_tournaments_tournament_users1_idx (id_user), INDEX fk_options_in_tournaments_tournaments1_idx (id_tournament), PRIMARY KEY(id_options_in_tournaments)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id_reset_password_request INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748A6B3CA4B (id_user), PRIMARY KEY(id_reset_password_request)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament (id_tournament INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, funny_icon VARCHAR(100) DEFAULT NULL, vote_to_datetime DATETIME DEFAULT NULL, select_to_datetime DATETIME DEFAULT NULL, is_public TINYINT(1) NOT NULL, create_at DATETIME DEFAULT CURRENT_TIMESTAMP, update_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id_tournament)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament_code (id_tournament_code INT AUTO_INCREMENT NOT NULL, id_tournament INT DEFAULT NULL, generated_code VARCHAR(255) NOT NULL, expire_at DATETIME DEFAULT NULL, create_at DATETIME DEFAULT CURRENT_TIMESTAMP, update_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX fk_tournaments_codes_tournaments1_idx (id_tournament), PRIMARY KEY(id_tournament_code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament_user (id_tournament_user INT AUTO_INCREMENT NOT NULL, id_tournament INT DEFAULT NULL, id_user INT DEFAULT NULL, tournament_user_type VARCHAR(255) NOT NULL, create_at DATETIME DEFAULT CURRENT_TIMESTAMP, update_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX fk_tournament_owners_tournaments1_idx (id_tournament), INDEX fk_tournament_owners_users1_idx (id_user), PRIMARY KEY(id_tournament_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id_user INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(45) NOT NULL, last_name VARCHAR(63) NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, create_at DATETIME DEFAULT CURRENT_TIMESTAMP, update_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, is_verified TINYINT(1) NOT NULL, photo_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id_vote INT AUTO_INCREMENT NOT NULL, id_option_in_tournament INT DEFAULT NULL, id_user INT DEFAULT NULL, id_tournament INT DEFAULT NULL, is_selected_by_promoter TINYINT(1) NOT NULL, priority INT NOT NULL, create_at DATETIME DEFAULT CURRENT_TIMESTAMP, update_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX fk_votes_users1_idx (id_user), INDEX fk_votes_options_in_tournaments1_idx (id_option_in_tournament), INDEX fk_votes_tournaments1_idx (id_tournament), PRIMARY KEY(id_vote)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE option_in_tournament ADD CONSTRAINT FK_60FC74B76B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE option_in_tournament ADD CONSTRAINT FK_60FC74B718D5380E FOREIGN KEY (id_tournament) REFERENCES tournament (id_tournament)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748A6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE tournament_code ADD CONSTRAINT FK_409882A618D5380E FOREIGN KEY (id_tournament) REFERENCES tournament (id_tournament)');
        $this->addSql('ALTER TABLE tournament_user ADD CONSTRAINT FK_BA1E647718D5380E FOREIGN KEY (id_tournament) REFERENCES tournament (id_tournament)');
        $this->addSql('ALTER TABLE tournament_user ADD CONSTRAINT FK_BA1E64776B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646C0C8513 FOREIGN KEY (id_option_in_tournament) REFERENCES option_in_tournament (id_options_in_tournaments)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085646B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856418D5380E FOREIGN KEY (id_tournament) REFERENCES tournament (id_tournament)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646C0C8513');
        $this->addSql('ALTER TABLE option_in_tournament DROP FOREIGN KEY FK_60FC74B718D5380E');
        $this->addSql('ALTER TABLE tournament_code DROP FOREIGN KEY FK_409882A618D5380E');
        $this->addSql('ALTER TABLE tournament_user DROP FOREIGN KEY FK_BA1E647718D5380E');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856418D5380E');
        $this->addSql('ALTER TABLE option_in_tournament DROP FOREIGN KEY FK_60FC74B76B3CA4B');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748A6B3CA4B');
        $this->addSql('ALTER TABLE tournament_user DROP FOREIGN KEY FK_BA1E64776B3CA4B');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085646B3CA4B');
        $this->addSql('DROP TABLE option_in_tournament');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE tournament_code');
        $this->addSql('DROP TABLE tournament_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
    }
}
