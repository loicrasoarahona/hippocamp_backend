<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250828093732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_private_chat_announcement (id SERIAL NOT NULL, chat_id INT NOT NULL, content TEXT NOT NULL, timestamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C4B00BEA1A9A7125 ON course_private_chat_announcement (chat_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat_announcement ADD CONSTRAINT FK_C4B00BEA1A9A7125 FOREIGN KEY (chat_id) REFERENCES course_private_chat (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat ADD last_announcement_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat ADD CONSTRAINT FK_7495FEE97B81AA27 FOREIGN KEY (last_announcement_id) REFERENCES course_private_chat_announcement (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7495FEE97B81AA27 ON course_private_chat (last_announcement_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat DROP CONSTRAINT FK_7495FEE97B81AA27
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat_announcement DROP CONSTRAINT FK_C4B00BEA1A9A7125
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_private_chat_announcement
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7495FEE97B81AA27
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat DROP last_announcement_id
        SQL);
    }
}
