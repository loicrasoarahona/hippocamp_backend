<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250517091703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE administrator (id SERIAL NOT NULL, m_user_id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_58DF0651FD219FDC ON administrator (m_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE student (id SERIAL NOT NULL, m_user_id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_B723AF33FD219FDC ON student (m_user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651FD219FDC FOREIGN KEY (m_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student ADD CONSTRAINT FK_B723AF33FD219FDC FOREIGN KEY (m_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE administrator DROP CONSTRAINT FK_58DF0651FD219FDC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student DROP CONSTRAINT FK_B723AF33FD219FDC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE administrator
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE student
        SQL);
    }
}
