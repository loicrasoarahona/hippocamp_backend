<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250623190223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz (id SERIAL NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_question (id SERIAL NOT NULL, quiz_id INT NOT NULL, index INT DEFAULT NULL, content TEXT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6033B00B853CD175 ON quiz_question (quiz_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_question_option (id SERIAL NOT NULL, question_id INT NOT NULL, index INT DEFAULT NULL, content TEXT NOT NULL, explanation TEXT DEFAULT NULL, is_correct BOOLEAN NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_66DF95E91E27F6BF ON quiz_question_option (question_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_question_option ADD CONSTRAINT FK_66DF95E91E27F6BF FOREIGN KEY (question_id) REFERENCES quiz_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_question DROP CONSTRAINT FK_6033B00B853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_question_option DROP CONSTRAINT FK_66DF95E91E27F6BF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_question_option
        SQL);
    }
}
