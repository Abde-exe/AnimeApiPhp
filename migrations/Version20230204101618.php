<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204101618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_anime (user_id INT NOT NULL, anime_id INT NOT NULL, INDEX IDX_F1C6A21AA76ED395 (user_id), INDEX IDX_F1C6A21A794BBE89 (anime_id), PRIMARY KEY(user_id, anime_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_character (user_id INT NOT NULL, character_id INT NOT NULL, INDEX IDX_939A3DD0A76ED395 (user_id), INDEX IDX_939A3DD01136BE75 (character_id), PRIMARY KEY(user_id, character_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_anime ADD CONSTRAINT FK_F1C6A21AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_anime ADD CONSTRAINT FK_F1C6A21A794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_character ADD CONSTRAINT FK_939A3DD0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_character ADD CONSTRAINT FK_939A3DD01136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime ADD studio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_13045942446F285F FOREIGN KEY (studio_id) REFERENCES studio (id)');
        $this->addSql('CREATE INDEX IDX_13045942446F285F ON anime (studio_id)');
        $this->addSql('ALTER TABLE `character` ADD anime_id INT NOT NULL');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('CREATE INDEX IDX_937AB034794BBE89 ON `character` (anime_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_anime DROP FOREIGN KEY FK_F1C6A21AA76ED395');
        $this->addSql('ALTER TABLE user_anime DROP FOREIGN KEY FK_F1C6A21A794BBE89');
        $this->addSql('ALTER TABLE user_character DROP FOREIGN KEY FK_939A3DD0A76ED395');
        $this->addSql('ALTER TABLE user_character DROP FOREIGN KEY FK_939A3DD01136BE75');
        $this->addSql('DROP TABLE user_anime');
        $this->addSql('DROP TABLE user_character');
        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_13045942446F285F');
        $this->addSql('DROP INDEX IDX_13045942446F285F ON anime');
        $this->addSql('ALTER TABLE anime DROP studio_id');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034794BBE89');
        $this->addSql('DROP INDEX IDX_937AB034794BBE89 ON `character`');
        $this->addSql('ALTER TABLE `character` DROP anime_id');
    }
}
