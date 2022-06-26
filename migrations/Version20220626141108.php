<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626141108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, couleur VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, child_id INT NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ratio_money DOUBLE PRECISION NOT NULL, point_bonus INT NOT NULL, signed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', archived_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E98F2859727ACA70 (parent_id), UNIQUE INDEX UNIQ_E98F2859DD62C21B (child_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, contract_id INT NOT NULL, description LONGTEXT NOT NULL, title LONGTEXT NOT NULL, points INT NOT NULL, is_repeated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_9067F23C12469DE2 (category_id), INDEX IDX_9067F23C2576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, mission_id INT NOT NULL, parent_rating INT DEFAULT NULL, child_rating INT DEFAULT NULL, week DATE NOT NULL, INDEX IDX_D8892622BE6CAE90 (mission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reward (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, points INT NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_4ED17253A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, wallet_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, expired_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649712520F3 (wallet_id), INDEX IDX_8D93D649727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, points INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week (id INT AUTO_INCREMENT NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859727ACA70 FOREIGN KEY (parent_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859DD62C21B FOREIGN KEY (child_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('ALTER TABLE reward ADD CONSTRAINT FK_4ED17253A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649727ACA70 FOREIGN KEY (parent_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C12469DE2');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C2576E0FD');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622BE6CAE90');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859727ACA70');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859DD62C21B');
        $this->addSql('ALTER TABLE reward DROP FOREIGN KEY FK_4ED17253A76ED395');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649727ACA70');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649712520F3');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE reward');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP TABLE week');
    }
}
