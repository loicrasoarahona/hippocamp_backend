<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250810122344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_private_chat (id SERIAL NOT NULL, student_id INT NOT NULL, course_id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7495FEE9CB944F1A ON course_private_chat (student_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7495FEE9591CC992 ON course_private_chat (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE course_private_chat_message (id SERIAL NOT NULL, type_id INT NOT NULL, chat_id INT NOT NULL, m_user_id INT NOT NULL, content TEXT NOT NULL, timestamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2BD26F33C54C8C93 ON course_private_chat_message (type_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2BD26F331A9A7125 ON course_private_chat_message (chat_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2BD26F33FD219FDC ON course_private_chat_message (m_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE message_type (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat ADD CONSTRAINT FK_7495FEE9CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat ADD CONSTRAINT FK_7495FEE9591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat_message ADD CONSTRAINT FK_2BD26F33C54C8C93 FOREIGN KEY (type_id) REFERENCES message_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat_message ADD CONSTRAINT FK_2BD26F331A9A7125 FOREIGN KEY (chat_id) REFERENCES course_private_chat (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat_message ADD CONSTRAINT FK_2BD26F33FD219FDC FOREIGN KEY (m_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat DROP CONSTRAINT FK_7495FEE9CB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat DROP CONSTRAINT FK_7495FEE9591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat_message DROP CONSTRAINT FK_2BD26F33C54C8C93
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat_message DROP CONSTRAINT FK_2BD26F331A9A7125
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_private_chat_message DROP CONSTRAINT FK_2BD26F33FD219FDC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_private_chat
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_private_chat_message
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message_type
        SQL);
    }
}
