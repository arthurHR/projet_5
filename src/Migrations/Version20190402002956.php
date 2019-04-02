<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190402002956 extends AbstractMigration
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
        $this->addSql('ALTER TABLE skills ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skills ADD CONSTRAINT FK_D5311670A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_D5311670A76ED395 ON skills (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE about DROP FOREIGN KEY FK_B5F422E3A76ED395');
        $this->addSql('DROP INDEX IDX_B5F422E3A76ED395 ON about');
        $this->addSql('ALTER TABLE skills DROP FOREIGN KEY FK_D5311670A76ED395');
        $this->addSql('DROP INDEX IDX_D5311670A76ED395 ON skills');
        $this->addSql('ALTER TABLE skills DROP user_id');
    }
}
