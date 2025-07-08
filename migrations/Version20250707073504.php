<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250707073504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_event (id SERIAL NOT NULL, type_id INT NOT NULL, course_id INT NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D2050D4FC54C8C93 ON course_event (type_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D2050D4F591CC992 ON course_event (course_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE course_event_type (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_event ADD CONSTRAINT FK_D2050D4FC54C8C93 FOREIGN KEY (type_id) REFERENCES course_event_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_event ADD CONSTRAINT FK_D2050D4F591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_event DROP CONSTRAINT FK_D2050D4FC54C8C93
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_event DROP CONSTRAINT FK_D2050D4F591CC992
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_event_type
        SQL);
    }
}
