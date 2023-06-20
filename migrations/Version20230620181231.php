<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620181231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE car_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE localization_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE car (id INT NOT NULL, start_localization_id INT DEFAULT NULL, end_localization_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, max_load_weight INT NOT NULL, registration_number VARCHAR(255) DEFAULT NULL, avarage_fuel_consumption INT NOT NULL, average_speed INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_773DE69DFDE7BA1 ON car (start_localization_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D8A4D8E8F ON car (end_localization_id)');
        $this->addSql('CREATE TABLE localization (id INT NOT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION NOT NULL, lon DOUBLE PRECISION NOT NULL, type VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DFDE7BA1 FOREIGN KEY (start_localization_id) REFERENCES localization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D8A4D8E8F FOREIGN KEY (end_localization_id) REFERENCES localization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE car_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE localization_id_seq CASCADE');
        $this->addSql('ALTER TABLE car DROP CONSTRAINT FK_773DE69DFDE7BA1');
        $this->addSql('ALTER TABLE car DROP CONSTRAINT FK_773DE69D8A4D8E8F');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE localization');
    }
}
