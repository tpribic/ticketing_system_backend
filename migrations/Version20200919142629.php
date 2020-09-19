<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200919142629 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE priority (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issue_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issue (id INT AUTO_INCREMENT NOT NULL, type_id_id INT NOT NULL, user_id INT NOT NULL, employee_id INT DEFAULT NULL, priority_id_id INT NOT NULL, product_id_id INT NOT NULL, name VARCHAR(45) NOT NULL, description VARCHAR(45) NOT NULL, is_solved TINYINT(1) NOT NULL, INDEX IDX_12AD233E714819A0 (type_id_id), INDEX IDX_12AD233EA76ED395 (user_id), INDEX IDX_12AD233E8C03F15C (employee_id), INDEX IDX_12AD233E80838C8A (priority_id_id), INDEX IDX_12AD233EDE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, issue_id INT NOT NULL, user_id INT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C5E7AA58C (issue_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E714819A0 FOREIGN KEY (type_id_id) REFERENCES issue_type (id)');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233EA76ED395 FOREIGN KEY (user_id) REFERENCES user_entity (id)');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E8C03F15C FOREIGN KEY (employee_id) REFERENCES user_entity (id)');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E80838C8A FOREIGN KEY (priority_id_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233EDE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user_entity (id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD9D86650F');
        $this->addSql('DROP INDEX IDX_D34A04AD9D86650F ON product');
        $this->addSql('ALTER TABLE product ADD type_id_id INT NOT NULL, CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD714819A0 FOREIGN KEY (type_id_id) REFERENCES product_type (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA76ED395 FOREIGN KEY (user_id) REFERENCES user_entity (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD714819A0 ON product (type_id_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA76ED395 ON product (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5E7AA58C');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E714819A0');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E80838C8A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD714819A0');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE issue_type');
        $this->addSql('DROP TABLE priority');
        $this->addSql('DROP TABLE product_type');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA76ED395');
        $this->addSql('DROP INDEX IDX_D34A04AD714819A0 ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADA76ED395 ON product');
        $this->addSql('ALTER TABLE product DROP type_id_id, CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9D86650F FOREIGN KEY (user_id_id) REFERENCES user_entity (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D34A04AD9D86650F ON product (user_id_id)');
    }
}
