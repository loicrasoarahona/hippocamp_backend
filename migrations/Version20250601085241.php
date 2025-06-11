<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250601085241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, date_start DATE NOT NULL, default_location VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE course_teacher (course_id INT NOT NULL, teacher_id INT NOT NULL, PRIMARY KEY(course_id, teacher_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B835A339591CC992 ON course_teacher (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B835A33941807E1D ON course_teacher (teacher_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_teacher ADD CONSTRAINT FK_B835A339591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_teacher ADD CONSTRAINT FK_B835A33941807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_teacher DROP CONSTRAINT FK_B835A339591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_teacher DROP CONSTRAINT FK_B835A33941807E1D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_teacher
        SQL);
    }
}
