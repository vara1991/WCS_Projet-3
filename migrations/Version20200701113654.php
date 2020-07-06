<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701113654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE response_score (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, eval_score_id INT NOT NULL, INDEX IDX_22EFEC01456C5646 (evaluation_id), INDEX IDX_22EFEC01577CFD42 (eval_score_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_yn (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, eval_yn_id INT NOT NULL, INDEX IDX_51E4D30F456C5646 (evaluation_id), INDEX IDX_51E4D30F4C493F27 (eval_yn_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE response_score ADD CONSTRAINT FK_22EFEC01456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE response_score ADD CONSTRAINT FK_22EFEC01577CFD42 FOREIGN KEY (eval_score_id) REFERENCES eval_score (id)');
        $this->addSql('ALTER TABLE response_yn ADD CONSTRAINT FK_51E4D30F456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE response_yn ADD CONSTRAINT FK_51E4D30F4C493F27 FOREIGN KEY (eval_yn_id) REFERENCES eval_yn (id)');
        $this->addSql('DROP TABLE evaluation_eval_score');
        $this->addSql('DROP TABLE evaluation_eval_yn');
        $this->addSql('DROP TABLE migration_versions');
        //$this->addSql('ALTER TABLE evaluation CHANGE training_id training_id INT NOT NULL, CHANGE company_id company_id INT NOT NULL');
        $this->addSql('ALTER TABLE response_qcm CHANGE participant_id participant_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation_eval_score (evaluation_id INT NOT NULL, eval_score_id INT NOT NULL, INDEX IDX_E4CEA635456C5646 (evaluation_id), INDEX IDX_E4CEA635577CFD42 (eval_score_id), PRIMARY KEY(evaluation_id, eval_score_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evaluation_eval_yn (evaluation_id INT NOT NULL, eval_yn_id INT NOT NULL, INDEX IDX_5C3FBB41456C5646 (evaluation_id), INDEX IDX_5C3FBB414C493F27 (eval_yn_id), PRIMARY KEY(evaluation_id, eval_yn_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evaluation_eval_score ADD CONSTRAINT FK_E4CEA635456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eval_score ADD CONSTRAINT FK_E4CEA635577CFD42 FOREIGN KEY (eval_score_id) REFERENCES eval_score (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eval_yn ADD CONSTRAINT FK_5C3FBB41456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eval_yn ADD CONSTRAINT FK_5C3FBB414C493F27 FOREIGN KEY (eval_yn_id) REFERENCES eval_yn (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE response_score');
        $this->addSql('DROP TABLE response_yn');
        $this->addSql('ALTER TABLE evaluation CHANGE training_id training_id INT DEFAULT NULL, CHANGE company_id company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE response_qcm CHANGE participant_id participant_id INT DEFAULT NULL');
    }
}
