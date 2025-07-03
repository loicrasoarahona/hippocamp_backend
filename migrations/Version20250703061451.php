<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250703061451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE content_block ADD course_page_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content_block ADD CONSTRAINT FK_68D8C3F04856608 FOREIGN KEY (course_page_id) REFERENCES course_page (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_68D8C3F04856608 ON content_block (course_page_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content_block DROP CONSTRAINT FK_68D8C3F04856608
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_68D8C3F04856608
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content_block DROP course_page_id
        SQL);
    }
}
