<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250704162150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_course_page (course_id INT NOT NULL, course_page_id INT NOT NULL, PRIMARY KEY(course_id, course_page_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A8C65BF2591CC992 ON course_course_page (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A8C65BF24856608 ON course_course_page (course_page_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_page ADD CONSTRAINT FK_A8C65BF2591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_page ADD CONSTRAINT FK_A8C65BF24856608 FOREIGN KEY (course_page_id) REFERENCES course_page (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_page DROP CONSTRAINT FK_A8C65BF2591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_course_page DROP CONSTRAINT FK_A8C65BF24856608
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_course_page
        SQL);
    }
}
