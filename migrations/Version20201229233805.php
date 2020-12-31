<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201229233805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_in_tournament ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE tournament ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE tournament_code ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE tournament_user ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE vote ADD deleted_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_in_tournament DROP deleted_at');
        $this->addSql('ALTER TABLE tournament DROP deleted_at');
        $this->addSql('ALTER TABLE tournament_code DROP deleted_at');
        $this->addSql('ALTER TABLE tournament_user DROP deleted_at');
        $this->addSql('ALTER TABLE user DROP deleted_at');
        $this->addSql('ALTER TABLE vote DROP deleted_at');
    }
}
