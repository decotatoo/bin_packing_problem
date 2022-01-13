<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112025154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_815D270A13B3DB11');
        $this->addSql('DROP INDEX IDX_815D270AFEC09103');
        $this->addSql('CREATE TEMPORARY TABLE __temp__simulation_master AS SELECT simulation_id, master_id FROM simulation_master');
        $this->addSql('DROP TABLE simulation_master');
        $this->addSql('CREATE TABLE simulation_master (simulation_id INTEGER NOT NULL, master_id INTEGER NOT NULL, PRIMARY KEY(simulation_id, master_id), CONSTRAINT FK_815D270AFEC09103 FOREIGN KEY (simulation_id) REFERENCES simulation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_815D270A13B3DB11 FOREIGN KEY (master_id) REFERENCES master (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO simulation_master (simulation_id, master_id) SELECT simulation_id, master_id FROM __temp__simulation_master');
        $this->addSql('DROP TABLE __temp__simulation_master');
        $this->addSql('CREATE INDEX IDX_815D270A13B3DB11 ON simulation_master (master_id)');
        $this->addSql('CREATE INDEX IDX_815D270AFEC09103 ON simulation_master (simulation_id)');
        $this->addSql('DROP INDEX IDX_19F31414F8BD700D');
        $this->addSql('DROP INDEX IDX_19F31414FEC09103');
        $this->addSql('CREATE TEMPORARY TABLE __temp__simulation_unit AS SELECT simulation_id, unit_id FROM simulation_unit');
        $this->addSql('DROP TABLE simulation_unit');
        $this->addSql('CREATE TABLE simulation_unit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, simulation_id INTEGER NOT NULL, unit_id INTEGER NOT NULL, qty INTEGER NOT NULL, CONSTRAINT FK_19F31414FEC09103 FOREIGN KEY (simulation_id) REFERENCES simulation (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_19F31414F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO simulation_unit (simulation_id, unit_id) SELECT simulation_id, unit_id FROM __temp__simulation_unit');
        $this->addSql('DROP TABLE __temp__simulation_unit');
        $this->addSql('CREATE INDEX IDX_19F31414F8BD700D ON simulation_unit (unit_id)');
        $this->addSql('CREATE INDEX IDX_19F31414FEC09103 ON simulation_unit (simulation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_815D270AFEC09103');
        $this->addSql('DROP INDEX IDX_815D270A13B3DB11');
        $this->addSql('CREATE TEMPORARY TABLE __temp__simulation_master AS SELECT simulation_id, master_id FROM simulation_master');
        $this->addSql('DROP TABLE simulation_master');
        $this->addSql('CREATE TABLE simulation_master (simulation_id INTEGER NOT NULL, master_id INTEGER NOT NULL, PRIMARY KEY(simulation_id, master_id))');
        $this->addSql('INSERT INTO simulation_master (simulation_id, master_id) SELECT simulation_id, master_id FROM __temp__simulation_master');
        $this->addSql('DROP TABLE __temp__simulation_master');
        $this->addSql('CREATE INDEX IDX_815D270AFEC09103 ON simulation_master (simulation_id)');
        $this->addSql('CREATE INDEX IDX_815D270A13B3DB11 ON simulation_master (master_id)');
        $this->addSql('DROP INDEX IDX_19F31414FEC09103');
        $this->addSql('DROP INDEX IDX_19F31414F8BD700D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__simulation_unit AS SELECT simulation_id, unit_id FROM simulation_unit');
        $this->addSql('DROP TABLE simulation_unit');
        $this->addSql('CREATE TABLE simulation_unit (simulation_id INTEGER NOT NULL, unit_id INTEGER NOT NULL, PRIMARY KEY(simulation_id, unit_id))');
        $this->addSql('INSERT INTO simulation_unit (simulation_id, unit_id) SELECT simulation_id, unit_id FROM __temp__simulation_unit');
        $this->addSql('DROP TABLE __temp__simulation_unit');
        $this->addSql('CREATE INDEX IDX_19F31414FEC09103 ON simulation_unit (simulation_id)');
        $this->addSql('CREATE INDEX IDX_19F31414F8BD700D ON simulation_unit (unit_id)');
    }
}
