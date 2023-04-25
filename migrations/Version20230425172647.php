<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425172647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE point_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE route_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE set_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE point (id INT NOT NULL, set_id INT DEFAULT NULL, route_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lat DOUBLE PRECISION NOT NULL, lon DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B7A5F32410FB0D18 ON point (set_id)');
        $this->addSql('CREATE INDEX IDX_B7A5F32434ECB4E6 ON point (route_id)');
        $this->addSql('CREATE TABLE route (id INT NOT NULL, set_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2C4207910FB0D18 ON route (set_id)');
        $this->addSql('CREATE TABLE set (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE point ADD CONSTRAINT FK_B7A5F32410FB0D18 FOREIGN KEY (set_id) REFERENCES set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE point ADD CONSTRAINT FK_B7A5F32434ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C4207910FB0D18 FOREIGN KEY (set_id) REFERENCES set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE point_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE route_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE set_id_seq CASCADE');
        $this->addSql('ALTER TABLE point DROP CONSTRAINT FK_B7A5F32410FB0D18');
        $this->addSql('ALTER TABLE point DROP CONSTRAINT FK_B7A5F32434ECB4E6');
        $this->addSql('ALTER TABLE route DROP CONSTRAINT FK_2C4207910FB0D18');
        $this->addSql('DROP TABLE point');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE set');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
