<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250712124159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_part (id SERIAL NOT NULL, course_id INT NOT NULL, name TEXT NOT NULL, y_index INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_81ADADC0591CC992 ON course_part (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_part ADD CONSTRAINT FK_81ADADC0591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_part DROP CONSTRAINT FK_81ADADC0591CC992
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_part
        SQL);
    }
}
