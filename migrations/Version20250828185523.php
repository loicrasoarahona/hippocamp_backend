<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250828185523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_forum (id SERIAL NOT NULL, course_id INT NOT NULL, m_user_id INT NOT NULL, subject TEXT NOT NULL, timestamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6C80B925591CC992 ON course_forum (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6C80B925FD219FDC ON course_forum (m_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE course_forum_reply (id SERIAL NOT NULL, m_user_id INT NOT NULL, forum_id INT NOT NULL, content TEXT NOT NULL, timestamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_91B250E3FD219FDC ON course_forum_reply (m_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_91B250E329CCBAD0 ON course_forum_reply (forum_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_forum ADD CONSTRAINT FK_6C80B925591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_forum ADD CONSTRAINT FK_6C80B925FD219FDC FOREIGN KEY (m_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_forum_reply ADD CONSTRAINT FK_91B250E3FD219FDC FOREIGN KEY (m_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_forum_reply ADD CONSTRAINT FK_91B250E329CCBAD0 FOREIGN KEY (forum_id) REFERENCES course_forum (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_forum DROP CONSTRAINT FK_6C80B925591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_forum DROP CONSTRAINT FK_6C80B925FD219FDC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_forum_reply DROP CONSTRAINT FK_91B250E3FD219FDC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_forum_reply DROP CONSTRAINT FK_91B250E329CCBAD0
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_forum
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_forum_reply
        SQL);
    }
}
