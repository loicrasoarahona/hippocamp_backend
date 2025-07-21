<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717112221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE student_course_ended_chapter (id SERIAL NOT NULL, student_course_id INT NOT NULL, chapter_id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8EF206883E720812 ON student_course_ended_chapter (student_course_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8EF20688579F4768 ON student_course_ended_chapter (chapter_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course_ended_chapter ADD CONSTRAINT FK_8EF206883E720812 FOREIGN KEY (student_course_id) REFERENCES student_course (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course_ended_chapter ADD CONSTRAINT FK_8EF20688579F4768 FOREIGN KEY (chapter_id) REFERENCES course_chapter (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course_ended_chapter DROP CONSTRAINT FK_8EF206883E720812
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course_ended_chapter DROP CONSTRAINT FK_8EF20688579F4768
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE student_course_ended_chapter
        SQL);
    }
}
