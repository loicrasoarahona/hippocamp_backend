<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250703060745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE content_block (id SERIAL NOT NULL, type_id INT NOT NULL, label VARCHAR(255) DEFAULT NULL, content TEXT NOT NULL, description VARCHAR(255) DEFAULT NULL, y_index INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_68D8C3F0C54C8C93 ON content_block (type_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE content_block_type (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE course_page (id SERIAL NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content_block ADD CONSTRAINT FK_68D8C3F0C54C8C93 FOREIGN KEY (type_id) REFERENCES content_block_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content_block DROP CONSTRAINT FK_68D8C3F0C54C8C93
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE content_block
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE content_block_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_page
        SQL);
    }
}
