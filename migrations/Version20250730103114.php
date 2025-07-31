<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250730103114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE pre_course_quiz (id SERIAL NOT NULL, course_id INT NOT NULL, quiz_id INT NOT NULL, course_part_suggestion_id INT DEFAULT NULL, passing_score DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_808A94EB591CC992 ON pre_course_quiz (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_808A94EB853CD175 ON pre_course_quiz (quiz_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_808A94EBCD8FB12A ON pre_course_quiz (course_part_suggestion_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pre_course_quiz ADD CONSTRAINT FK_808A94EB591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pre_course_quiz ADD CONSTRAINT FK_808A94EB853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pre_course_quiz ADD CONSTRAINT FK_808A94EBCD8FB12A FOREIGN KEY (course_part_suggestion_id) REFERENCES course_part (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pre_course_quiz DROP CONSTRAINT FK_808A94EB591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pre_course_quiz DROP CONSTRAINT FK_808A94EB853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pre_course_quiz DROP CONSTRAINT FK_808A94EBCD8FB12A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pre_course_quiz
        SQL);
    }
}
