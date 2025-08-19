<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250818183919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_quiz_question_option DROP CONSTRAINT fk_c7dde723ac5339e1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_quiz_question_option DROP CONSTRAINT fk_c7dde723da289f63
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_answer_quiz_question_option
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_answer_quiz_question_option (quiz_answer_id INT NOT NULL, quiz_question_option_id INT NOT NULL, PRIMARY KEY(quiz_answer_id, quiz_question_option_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_c7dde723da289f63 ON quiz_answer_quiz_question_option (quiz_question_option_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_c7dde723ac5339e1 ON quiz_answer_quiz_question_option (quiz_answer_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_quiz_question_option ADD CONSTRAINT fk_c7dde723ac5339e1 FOREIGN KEY (quiz_answer_id) REFERENCES quiz_answer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_quiz_question_option ADD CONSTRAINT fk_c7dde723da289f63 FOREIGN KEY (quiz_question_option_id) REFERENCES quiz_question_option (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }
}
