<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200629160904 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE response_qcm (id INT AUTO_INCREMENT NOT NULL, participant_id INT NOT NULL, response_id INT NOT NULL, INDEX IDX_CA5224DF9D1C3019 (participant_id), INDEX IDX_CA5224DFFBF32840 (response_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE response_qcm ADD CONSTRAINT FK_CA5224DF9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE response_qcm ADD CONSTRAINT FK_CA5224DFFBF32840 FOREIGN KEY (response_id) REFERENCES response (id)');
        $this->addSql('DROP TABLE participant_response');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant_response (participant_id INT NOT NULL, response_id INT NOT NULL, INDEX IDX_303A8E069D1C3019 (participant_id), INDEX IDX_303A8E06FBF32840 (response_id), PRIMARY KEY(participant_id, response_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE participant_response ADD CONSTRAINT FK_303A8E069D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_response ADD CONSTRAINT FK_303A8E06FBF32840 FOREIGN KEY (response_id) REFERENCES response (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE response_qcm');
    }
}
