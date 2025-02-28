<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224114446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE short_url (id SERIAL NOT NULL, short_code VARCHAR(255) NOT NULL, url TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, max_visits INT DEFAULT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, valid_on TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN short_url.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN short_url.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN short_url.valid_on IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE short_url_tag (short_url_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(short_url_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_FD13B0B9F1252BC8 ON short_url_tag (short_url_id)');
        $this->addSql('CREATE INDEX IDX_FD13B0B9BAD26311 ON short_url_tag (tag_id)');
        $this->addSql('CREATE TABLE tag (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE visites (id SERIAL NOT NULL, short_url_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ip VARCHAR(255) NOT NULL, user_agent TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_470D3983F1252BC8 ON visites (short_url_id)');
        $this->addSql('COMMENT ON COLUMN visites.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE short_url_tag ADD CONSTRAINT FK_FD13B0B9F1252BC8 FOREIGN KEY (short_url_id) REFERENCES short_url (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE short_url_tag ADD CONSTRAINT FK_FD13B0B9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visites ADD CONSTRAINT FK_470D3983F1252BC8 FOREIGN KEY (short_url_id) REFERENCES short_url (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE short_url_tag DROP CONSTRAINT FK_FD13B0B9F1252BC8');
        $this->addSql('ALTER TABLE short_url_tag DROP CONSTRAINT FK_FD13B0B9BAD26311');
        $this->addSql('ALTER TABLE visites DROP CONSTRAINT FK_470D3983F1252BC8');
        $this->addSql('DROP TABLE short_url');
        $this->addSql('DROP TABLE short_url_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE visites');
    }
}
