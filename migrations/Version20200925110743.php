<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200925110743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E714819A0');
        $this->addSql('DROP TABLE issue_type');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E80838C8A');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233EDE18E50B');
        $this->addSql('DROP INDEX IDX_12AD233E714819A0 ON issue');
        $this->addSql('DROP INDEX IDX_12AD233E80838C8A ON issue');
        $this->addSql('DROP INDEX IDX_12AD233EDE18E50B ON issue');
        $this->addSql('ALTER TABLE issue ADD priority_id INT NOT NULL, ADD product_id INT NOT NULL, DROP type_id_id, DROP priority_id_id, DROP product_id_id');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E497B19F9 FOREIGN KEY (priority_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_12AD233E497B19F9 ON issue (priority_id)');
        $this->addSql('CREATE INDEX IDX_12AD233E4584665A ON issue (product_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADD948EE2 ON product (serial_number)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE issue_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E497B19F9');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E4584665A');
        $this->addSql('DROP INDEX IDX_12AD233E497B19F9 ON issue');
        $this->addSql('DROP INDEX IDX_12AD233E4584665A ON issue');
        $this->addSql('ALTER TABLE issue ADD type_id_id INT NOT NULL, ADD priority_id_id INT NOT NULL, ADD product_id_id INT NOT NULL, DROP priority_id, DROP product_id');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E714819A0 FOREIGN KEY (type_id_id) REFERENCES issue_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E80838C8A FOREIGN KEY (priority_id_id) REFERENCES priority (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233EDE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_12AD233E714819A0 ON issue (type_id_id)');
        $this->addSql('CREATE INDEX IDX_12AD233E80838C8A ON issue (priority_id_id)');
        $this->addSql('CREATE INDEX IDX_12AD233EDE18E50B ON issue (product_id_id)');
        $this->addSql('DROP INDEX UNIQ_D34A04ADD948EE2 ON product');
    }
}
