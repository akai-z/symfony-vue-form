<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210412044652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE airport (id INT AUTO_INCREMENT NOT NULL COMMENT \'ID\', name VARCHAR(128) NOT NULL COMMENT \'Airport Name\', UNIQUE INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE airport_terminal (id INT AUTO_INCREMENT NOT NULL COMMENT \'ID\', airport_id INT DEFAULT NULL COMMENT \'ID\', label VARCHAR(128) NOT NULL COMMENT \'Terminal Label\', INDEX airport_terminal (airport_id), UNIQUE INDEX airport_id_label (label, airport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL COMMENT \'ID\', customer_name VARCHAR(128) NOT NULL COMMENT \'Customer Name\', mobile VARCHAR(128) NOT NULL COMMENT \'Mobile Number\', date_of_arrival DATETIME NOT NULL COMMENT \'Date of Arrival\', airport_name VARCHAR(128) NOT NULL COMMENT \'Airport Name\', airport_terminal VARCHAR(128) DEFAULT NULL COMMENT \'Airport Terminal\', airflight_number VARCHAR(128) NOT NULL COMMENT \'Airflight Number\', INDEX airport (airport_name), INDEX mobile (mobile), INDEX customer_name (customer_name), UNIQUE INDEX mobile_date_of_arrival (mobile, date_of_arrival), UNIQUE INDEX mobile_airflight_number (mobile, airflight_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE airport_terminal ADD CONSTRAINT FK_BAB37785289F53C8 FOREIGN KEY (airport_id) REFERENCES airport (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE airport_terminal DROP FOREIGN KEY FK_BAB37785289F53C8');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE airport_terminal');
        $this->addSql('DROP TABLE booking');
    }
}
