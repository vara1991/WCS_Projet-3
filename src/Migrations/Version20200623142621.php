<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623142621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE evaluation_eval_yn (evaluation_id INT NOT NULL, eval_yn_id INT NOT NULL, INDEX IDX_5C3FBB41456C5646 (evaluation_id), INDEX IDX_5C3FBB414C493F27 (eval_yn_id), PRIMARY KEY(evaluation_id, eval_yn_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_eval_score (evaluation_id INT NOT NULL, eval_score_id INT NOT NULL, INDEX IDX_E4CEA635456C5646 (evaluation_id), INDEX IDX_E4CEA635577CFD42 (eval_score_id), PRIMARY KEY(evaluation_id, eval_score_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_qcm (id INT AUTO_INCREMENT NOT NULL, participant_id INT NOT NULL, response_id INT NOT NULL, INDEX IDX_CA5224DF9D1C3019 (participant_id), INDEX IDX_CA5224DFFBF32840 (response_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation_eval_yn ADD CONSTRAINT FK_5C3FBB41456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eval_yn ADD CONSTRAINT FK_5C3FBB414C493F27 FOREIGN KEY (eval_yn_id) REFERENCES eval_yn (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eval_score ADD CONSTRAINT FK_E4CEA635456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eval_score ADD CONSTRAINT FK_E4CEA635577CFD42 FOREIGN KEY (eval_score_id) REFERENCES eval_score (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE response_qcm ADD CONSTRAINT FK_CA5224DF9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE response_qcm ADD CONSTRAINT FK_CA5224DFFBF32840 FOREIGN KEY (response_id) REFERENCES response (id)');
        $this->addSql('DROP TABLE participant_response');
        $this->addSql('DROP TABLE response_score');
        $this->addSql('DROP TABLE response_yn');
        $this->addSql('ALTER TABLE evaluation CHANGE training_id training_id INT NOT NULL, CHANGE company_id company_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE participant_response (participant_id INT NOT NULL, response_id INT NOT NULL, INDEX IDX_303A8E069D1C3019 (participant_id), INDEX IDX_303A8E06FBF32840 (response_id), PRIMARY KEY(participant_id, response_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE response_score (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, eval_score_id INT NOT NULL, INDEX IDX_22EFEC01577CFD42 (eval_score_id), INDEX IDX_22EFEC01456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE response_yn (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, eval_yn_id INT NOT NULL, INDEX IDX_51E4D30F4C493F27 (eval_yn_id), INDEX IDX_51E4D30F456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE participant_response ADD CONSTRAINT FK_303A8E069D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_response ADD CONSTRAINT FK_303A8E06FBF32840 FOREIGN KEY (response_id) REFERENCES response (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE response_score ADD CONSTRAINT FK_22EFEC01456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE response_score ADD CONSTRAINT FK_22EFEC01577CFD42 FOREIGN KEY (eval_score_id) REFERENCES eval_score (id)');
        $this->addSql('ALTER TABLE response_yn ADD CONSTRAINT FK_51E4D30F456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE response_yn ADD CONSTRAINT FK_51E4D30F4C493F27 FOREIGN KEY (eval_yn_id) REFERENCES eval_yn (id)');
        $this->addSql('DROP TABLE evaluation_eval_yn');
        $this->addSql('DROP TABLE evaluation_eval_score');
        $this->addSql('DROP TABLE response_qcm');
        $this->addSql('ALTER TABLE evaluation CHANGE training_id training_id INT DEFAULT NULL, CHANGE company_id company_id INT DEFAULT NULL');
    }
}
