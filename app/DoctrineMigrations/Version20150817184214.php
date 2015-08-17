<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150817184214 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, username_canonical VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(60) NOT NULL, email_canonical VARCHAR(60) NOT NULL, gender SMALLINT NOT NULL, is_active TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', first_name VARCHAR(32) NOT NULL, last_name VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_C2502824F85E0677 (username), UNIQUE INDEX UNIQ_C250282492FC23A8 (username_canonical), UNIQUE INDEX UNIQ_C2502824E7927C74 (email), UNIQUE INDEX UNIQ_C2502824A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videos (id INT UNSIGNED AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, category_id INT UNSIGNED DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, original VARCHAR(255) NOT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_29AA6432F675F31B (author_id), INDEX IDX_29AA643212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_tags (video_id INT UNSIGNED NOT NULL, tag_id INT UNSIGNED NOT NULL, INDEX IDX_682BC9FA29C1004E (video_id), INDEX IDX_682BC9FABAD26311 (tag_id), PRIMARY KEY(video_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA6432F675F31B FOREIGN KEY (author_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA643212469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE video_tags ADD CONSTRAINT FK_682BC9FA29C1004E FOREIGN KEY (video_id) REFERENCES videos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_tags ADD CONSTRAINT FK_682BC9FABAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA6432F675F31B');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA643212469DE2');
        $this->addSql('ALTER TABLE video_tags DROP FOREIGN KEY FK_682BC9FABAD26311');
        $this->addSql('ALTER TABLE video_tags DROP FOREIGN KEY FK_682BC9FA29C1004E');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE videos');
        $this->addSql('DROP TABLE video_tags');
    }
}
