<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250722102047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_answer (id SERIAL NOT NULL, m_user_id INT NOT NULL, quiz_id INT NOT NULL, score DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3799BA7CFD219FDC ON quiz_answer (m_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3799BA7C853CD175 ON quiz_answer (quiz_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_answer_chosen_option (id SERIAL NOT NULL, quiz_answer_id INT NOT NULL, option_id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A3ACD2E4AC5339E1 ON quiz_answer_chosen_option (quiz_answer_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A3ACD2E4A7C41D6F ON quiz_answer_chosen_option (option_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer ADD CONSTRAINT FK_3799BA7CFD219FDC FOREIGN KEY (m_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer ADD CONSTRAINT FK_3799BA7C853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_chosen_option ADD CONSTRAINT FK_A3ACD2E4AC5339E1 FOREIGN KEY (quiz_answer_id) REFERENCES quiz_answer (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_chosen_option ADD CONSTRAINT FK_A3ACD2E4A7C41D6F FOREIGN KEY (option_id) REFERENCES quiz_question_option (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer DROP CONSTRAINT FK_3799BA7CFD219FDC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer DROP CONSTRAINT FK_3799BA7C853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_chosen_option DROP CONSTRAINT FK_A3ACD2E4AC5339E1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_answer_chosen_option DROP CONSTRAINT FK_A3ACD2E4A7C41D6F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_answer
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_answer_chosen_option
        SQL);
    }
}
