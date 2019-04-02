<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190401234701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE about ADD CONSTRAINT FK_B5F422E3A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_B5F422E3A76ED395 ON about (user_id)');
        $this->addSql('ALTER TABLE header ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE header ADD CONSTRAINT FK_6E72A8C1A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_6E72A8C1A76ED395 ON header (user_id)');
        $this->addSql('ALTER TABLE projects ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_5C93B3A4A76ED395 ON projects (user_id)');
        $this->addSql('ALTER TABLE skills CHANGE user_id user_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE about DROP FOREIGN KEY FK_B5F422E3A76ED395');
        $this->addSql('DROP INDEX IDX_B5F422E3A76ED395 ON about');
        $this->addSql('ALTER TABLE header DROP FOREIGN KEY FK_6E72A8C1A76ED395');
        $this->addSql('DROP INDEX IDX_6E72A8C1A76ED395 ON header');
        $this->addSql('ALTER TABLE header DROP user_id');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4A76ED395');
        $this->addSql('DROP INDEX IDX_5C93B3A4A76ED395 ON projects');
        $this->addSql('ALTER TABLE projects DROP user_id');
        $this->addSql('ALTER TABLE skills CHANGE user_id user_id INT NOT NULL');
    }
}
