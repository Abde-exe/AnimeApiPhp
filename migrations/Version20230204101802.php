<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204101802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('CREATE INDEX IDX_937AB034794BBE89 ON `character` (anime_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034794BBE89');
        $this->addSql('DROP INDEX IDX_937AB034794BBE89 ON `character`');
    }
}
