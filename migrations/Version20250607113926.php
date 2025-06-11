<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250607113926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_course_category (course_id INT NOT NULL, course_category_id INT NOT NULL, PRIMARY KEY(course_id, course_category_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8EB34CC5591CC992 ON course_course_category (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8EB34CC56628AD36 ON course_course_category (course_category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE course_category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_category ADD CONSTRAINT FK_8EB34CC5591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_category ADD CONSTRAINT FK_8EB34CC56628AD36 FOREIGN KEY (course_category_id) REFERENCES course_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_category DROP CONSTRAINT FK_8EB34CC5591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_category DROP CONSTRAINT FK_8EB34CC56628AD36
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_course_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_category
        SQL);
    }
}
