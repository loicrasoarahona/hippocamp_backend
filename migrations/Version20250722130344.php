<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250722130344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP SEQUENCE quiz_answer_chosen_option_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_answer_quiz_question_option (quiz_answer_id INT NOT NULL, quiz_question_option_id INT NOT NULL, PRIMARY KEY(quiz_answer_id, quiz_question_option_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C7DDE723AC5339E1 ON quiz_answer_quiz_question_option (quiz_answer_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C7DDE723DA289F63 ON quiz_answer_quiz_question_option (quiz_question_option_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_quiz_question_option ADD CONSTRAINT FK_C7DDE723AC5339E1 FOREIGN KEY (quiz_answer_id) REFERENCES quiz_answer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_quiz_question_option ADD CONSTRAINT FK_C7DDE723DA289F63 FOREIGN KEY (quiz_question_option_id) REFERENCES quiz_question_option (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_chosen_option DROP CONSTRAINT fk_a3acd2e4ac5339e1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_chosen_option DROP CONSTRAINT fk_a3acd2e4a7c41d6f
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_answer_chosen_option
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE quiz_answer_chosen_option_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_answer_chosen_option (id SERIAL NOT NULL, quiz_answer_id INT NOT NULL, option_id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_a3acd2e4a7c41d6f ON quiz_answer_chosen_option (option_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_a3acd2e4ac5339e1 ON quiz_answer_chosen_option (quiz_answer_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_chosen_option ADD CONSTRAINT fk_a3acd2e4ac5339e1 FOREIGN KEY (quiz_answer_id) REFERENCES quiz_answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_chosen_option ADD CONSTRAINT fk_a3acd2e4a7c41d6f FOREIGN KEY (option_id) REFERENCES quiz_question_option (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_quiz_question_option DROP CONSTRAINT FK_C7DDE723AC5339E1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_quiz_question_option DROP CONSTRAINT FK_C7DDE723DA289F63
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_answer_quiz_question_option
        SQL);
    }
}
