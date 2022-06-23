<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623133455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, couleur VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ratio_money DOUBLE PRECISION NOT NULL, point_bonus INT NOT NULL, INDEX IDX_E98F2859727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, week_id INT NOT NULL, user_id INT NOT NULL, parent_notation_id INT DEFAULT NULL, child_notation_id INT DEFAULT NULL, user_contract_id INT NOT NULL, description LONGTEXT NOT NULL, points INT NOT NULL, is_repeated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, INDEX IDX_9067F23C12469DE2 (category_id), INDEX IDX_9067F23CC86F3B2F (week_id), INDEX IDX_9067F23CA76ED395 (user_id), INDEX IDX_9067F23CFDACA587 (parent_notation_id), INDEX IDX_9067F23C4C04D0D9 (child_notation_id), INDEX IDX_9067F23C8C6D2968 (user_contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coefficient DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, wallet_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, expired_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649712520F3 (wallet_id), INDEX IDX_8D93D649727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_contract (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, contract_id INT NOT NULL, is_expired TINYINT(1) NOT NULL, signed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_902CC59A76ED395 (user_id), INDEX IDX_902CC592576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, points INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week (id INT AUTO_INCREMENT NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859727ACA70 FOREIGN KEY (parent_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CFDACA587 FOREIGN KEY (parent_notation_id) REFERENCES notation (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C4C04D0D9 FOREIGN KEY (child_notation_id) REFERENCES notation (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C8C6D2968 FOREIGN KEY (user_contract_id) REFERENCES user_contract (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649727ACA70 FOREIGN KEY (parent_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_contract ADD CONSTRAINT FK_902CC59A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_contract ADD CONSTRAINT FK_902CC592576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C12469DE2');
        $this->addSql('ALTER TABLE user_contract DROP FOREIGN KEY FK_902CC592576E0FD');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CFDACA587');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C4C04D0D9');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859727ACA70');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CA76ED395');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649727ACA70');
        $this->addSql('ALTER TABLE user_contract DROP FOREIGN KEY FK_902CC59A76ED395');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C8C6D2968');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649712520F3');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CC86F3B2F');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE notation');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_contract');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP TABLE week');
    }
}
