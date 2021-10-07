<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211006160545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE post_rating_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE post (id BIGINT NOT NULL, user_id INT NOT NULL, author VARCHAR(255) DEFAULT NULL, image VARCHAR(1023) NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (user_id)');
        $this->addSql('COMMENT ON COLUMN post.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN post.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE post_rating (user_id INT NOT NULL, post_id INT NOT NULL, rating SMALLINT NOT NULL, PRIMARY KEY(user_id, post_id))');
        $this->addSql('CREATE INDEX IDX_E8ABC2479D86650F ON post_rating (user_id)');
        $this->addSql('CREATE INDEX IDX_E8ABC247E85F12B8 ON post_rating (post_id)');
        $this->addSql('CREATE TABLE "user" (id BIGINT NOT NULL, email VARCHAR(180) NOT NULL UNIQUE, roles JSON DEFAULT NULL, password VARCHAR(255) NOT NULL, phone BIGINT CHECK(phone > 89000000000 AND phone <= 89999999999) NOT NULL UNIQUE, name VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL UNIQUE, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497BA2F5EB ON "user" (api_token)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_rating ADD CONSTRAINT FK_E8ABC2479D86650F FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_rating ADD CONSTRAINT FK_E8ABC247E85F12B8 FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE post_rating DROP CONSTRAINT FK_E8ABC247E85F12B8');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE post_rating DROP CONSTRAINT FK_E8ABC2479D86650F');
        $this->addSql('DROP SEQUENCE post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE post_rating_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_rating');
        $this->addSql('DROP TABLE "user"');
    }
}
