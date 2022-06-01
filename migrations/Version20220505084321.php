<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505084321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD wallet_id INT DEFAULT NULL, ADD parent_id INT DEFAULT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD token VARCHAR(255) DEFAULT NULL, ADD expired_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL, CHANGE password password LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649727ACA70 FOREIGN KEY (parent_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649712520F3 ON user (wallet_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649727ACA70 ON user (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649712520F3');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649727ACA70');
        $this->addSql('DROP INDEX UNIQ_8D93D649712520F3 ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D649727ACA70 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP wallet_id, DROP parent_id, DROP first_name, DROP last_name, DROP token, DROP expired_at, DROP created_at, DROP updated_at, CHANGE password password VARCHAR(255) NOT NULL');
    }
}
