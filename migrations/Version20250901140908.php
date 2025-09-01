<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250901140908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_comment (id SERIAL NOT NULL, student_id INT NOT NULL, course_id INT NOT NULL, content TEXT NOT NULL, rating DOUBLE PRECISION NOT NULL, timestamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9CB75780CB944F1A ON course_comment (student_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9CB75780591CC992 ON course_comment (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_comment ADD CONSTRAINT FK_9CB75780CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_comment ADD CONSTRAINT FK_9CB75780591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_comment DROP CONSTRAINT FK_9CB75780CB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_comment DROP CONSTRAINT FK_9CB75780591CC992
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_comment
        SQL);
    }
}
