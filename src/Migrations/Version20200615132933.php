<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200615132933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE evaluation_eval_score (evaluation_id INT NOT NULL, eval_score_id INT NOT NULL, INDEX IDX_E4CEA635456C5646 (evaluation_id), INDEX IDX_E4CEA635577CFD42 (eval_score_id), PRIMARY KEY(evaluation_id, eval_score_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation_eval_score ADD CONSTRAINT FK_E4CEA635456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eval_score ADD CONSTRAINT FK_E4CEA635577CFD42 FOREIGN KEY (eval_score_id) REFERENCES eval_score (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575577CFD42');
        $this->addSql('DROP INDEX IDX_1323A575577CFD42 ON evaluation');
        $this->addSql('ALTER TABLE evaluation DROP eval_score_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE evaluation_eval_score');
        $this->addSql('ALTER TABLE evaluation ADD eval_score_id INT NOT NULL');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575577CFD42 FOREIGN KEY (eval_score_id) REFERENCES eval_score (id)');
        $this->addSql('CREATE INDEX IDX_1323A575577CFD42 ON evaluation (eval_score_id)');
    }
}
