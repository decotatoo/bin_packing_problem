<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112021146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE master (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ref VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, base_weight INTEGER NOT NULL, max_weight INTEGER DEFAULT NULL, in_w INTEGER NOT NULL, in_l INTEGER NOT NULL, in_d INTEGER NOT NULL, out_w INTEGER NOT NULL, out_l INTEGER NOT NULL, out_d INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE simulation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, result CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE TABLE simulation_master (simulation_id INTEGER NOT NULL, master_id INTEGER NOT NULL, PRIMARY KEY(simulation_id, master_id))');
        $this->addSql('CREATE INDEX IDX_815D270AFEC09103 ON simulation_master (simulation_id)');
        $this->addSql('CREATE INDEX IDX_815D270A13B3DB11 ON simulation_master (master_id)');
        $this->addSql('CREATE TABLE simulation_unit (simulation_id INTEGER NOT NULL, unit_id INTEGER NOT NULL, PRIMARY KEY(simulation_id, unit_id))');
        $this->addSql('CREATE INDEX IDX_19F31414FEC09103 ON simulation_unit (simulation_id)');
        $this->addSql('CREATE INDEX IDX_19F31414F8BD700D ON simulation_unit (unit_id)');
        $this->addSql('CREATE TABLE unit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ref VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, w INTEGER NOT NULL, l INTEGER NOT NULL, h INTEGER NOT NULL, ice BOOLEAN DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE master');
        $this->addSql('DROP TABLE simulation');
        $this->addSql('DROP TABLE simulation_master');
        $this->addSql('DROP TABLE simulation_unit');
        $this->addSql('DROP TABLE unit');
    }
}
