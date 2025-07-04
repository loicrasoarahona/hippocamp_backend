<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250704162900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_page DROP CONSTRAINT fk_a8c65bf2591cc992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_page DROP CONSTRAINT fk_a8c65bf24856608
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_course_page
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course ADD welcome_page_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course ADD CONSTRAINT FK_169E6FB965989E6D FOREIGN KEY (welcome_page_id) REFERENCES course_page (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_169E6FB965989E6D ON course (welcome_page_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE course_course_page (course_id INT NOT NULL, course_page_id INT NOT NULL, PRIMARY KEY(course_id, course_page_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_a8c65bf24856608 ON course_course_page (course_page_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_a8c65bf2591cc992 ON course_course_page (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_page ADD CONSTRAINT fk_a8c65bf2591cc992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_page ADD CONSTRAINT fk_a8c65bf24856608 FOREIGN KEY (course_page_id) REFERENCES course_page (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course DROP CONSTRAINT FK_169E6FB965989E6D
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_169E6FB965989E6D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course DROP welcome_page_id
        SQL);
    }
}
