<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722065502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, cat VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notation (id INT AUTO_INCREMENT NOT NULL, restaurant_id_id INT NOT NULL, utilisateur_id_id INT NOT NULL, note VARCHAR(10) NOT NULL, commentaire LONGTEXT DEFAULT NULL, INDEX IDX_268BC9535592D86 (restaurant_id_id), INDEX IDX_268BC95B981C689 (utilisateur_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, categorie_id_id INT NOT NULL, nom VARCHAR(50) NOT NULL, adresse VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, nationalite VARCHAR(30) NOT NULL, specificite VARCHAR(30) DEFAULT NULL, prix_moyen VARCHAR(15) NOT NULL, photo VARCHAR(255) DEFAULT NULL, INDEX IDX_EB95123F8A3C7387 (categorie_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(70) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC9535592D86 FOREIGN KEY (restaurant_id_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC95B981C689 FOREIGN KEY (utilisateur_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F8A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F8A3C7387');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC9535592D86');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC95B981C689');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE notation');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE user');
    }
}
