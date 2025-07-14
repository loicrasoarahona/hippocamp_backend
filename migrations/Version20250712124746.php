<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250712124746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_chapter (id SERIAL NOT NULL, page_id INT DEFAULT NULL, course_part_id INT NOT NULL, name TEXT NOT NULL, y_index INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F142B0C2C4663E4 ON course_chapter (page_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F142B0C244204E00 ON course_chapter (course_part_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_chapter ADD CONSTRAINT FK_F142B0C2C4663E4 FOREIGN KEY (page_id) REFERENCES course_page (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_chapter ADD CONSTRAINT FK_F142B0C244204E00 FOREIGN KEY (course_part_id) REFERENCES course_part (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_chapter DROP CONSTRAINT FK_F142B0C2C4663E4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_chapter DROP CONSTRAINT FK_F142B0C244204E00
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_chapter
        SQL);
    }
}
