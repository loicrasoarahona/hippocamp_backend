<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250715150310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE student_course (id SERIAL NOT NULL, course_id INT NOT NULL, student_id INT NOT NULL, registered_by_id INT DEFAULT NULL, registered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_98A8B739591CC992 ON student_course (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_98A8B739CB944F1A ON student_course (student_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_98A8B73927E92E18 ON student_course (registered_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN student_course.registered_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN student_course.requested_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course ADD CONSTRAINT FK_98A8B73927E92E18 FOREIGN KEY (registered_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course DROP CONSTRAINT FK_98A8B739591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course DROP CONSTRAINT FK_98A8B739CB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student_course DROP CONSTRAINT FK_98A8B73927E92E18
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE student_course
        SQL);
    }
}
