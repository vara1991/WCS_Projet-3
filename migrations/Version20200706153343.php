<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200706153343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE civility (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eval_question (id INT AUTO_INCREMENT NOT NULL, question LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eval_score (id INT AUTO_INCREMENT NOT NULL, score INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eval_yn (id INT AUTO_INCREMENT NOT NULL, response VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, training_id INT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, global_score INT NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_1323A575BEFD98D1 (training_id), INDEX IDX_1323A575979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, session_id INT NOT NULL, evaluation_id INT DEFAULT NULL, civility_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_D79F6B11979B1AD6 (company_id), INDEX IDX_D79F6B11613FECDF (session_id), UNIQUE INDEX UNIQ_D79F6B11456C5646 (evaluation_id), INDEX IDX_D79F6B1123D6A298 (civility_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_qcm (id INT AUTO_INCREMENT NOT NULL, participant_id INT NOT NULL, response_id INT NOT NULL, INDEX IDX_CA5224DF9D1C3019 (participant_id), INDEX IDX_CA5224DFFBF32840 (response_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_score (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, eval_score_id INT NOT NULL, INDEX IDX_22EFEC01456C5646 (evaluation_id), INDEX IDX_22EFEC01577CFD42 (eval_score_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_yn (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, eval_yn_id INT NOT NULL, INDEX IDX_51E4D30F456C5646 (evaluation_id), INDEX IDX_51E4D30F4C493F27 (eval_yn_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, user_id INT DEFAULT NULL, is_archived TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, connection_number INT NOT NULL, INDEX IDX_D044D5D4979B1AD6 (company_id), UNIQUE INDEX UNIQ_D044D5D4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainer (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, trainer_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, face_date DATETIME NOT NULL, hours INT NOT NULL, UNIQUE INDEX UNIQ_D5128A8F613FECDF (session_id), INDEX IDX_D5128A8FFB08EDF6 (trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1123D6A298 FOREIGN KEY (civility_id) REFERENCES civility (id)');
        $this->addSql('ALTER TABLE response_qcm ADD CONSTRAINT FK_CA5224DF9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE response_qcm ADD CONSTRAINT FK_CA5224DFFBF32840 FOREIGN KEY (response_id) REFERENCES response (id)');
        $this->addSql('ALTER TABLE response_score ADD CONSTRAINT FK_22EFEC01456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE response_score ADD CONSTRAINT FK_22EFEC01577CFD42 FOREIGN KEY (eval_score_id) REFERENCES eval_score (id)');
        $this->addSql('ALTER TABLE response_yn ADD CONSTRAINT FK_51E4D30F456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE response_yn ADD CONSTRAINT FK_51E4D30F4C493F27 FOREIGN KEY (eval_yn_id) REFERENCES eval_yn (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8FFB08EDF6 FOREIGN KEY (trainer_id) REFERENCES trainer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1123D6A298');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575979B1AD6');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11979B1AD6');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4979B1AD6');
        $this->addSql('ALTER TABLE response_score DROP FOREIGN KEY FK_22EFEC01577CFD42');
        $this->addSql('ALTER TABLE response_yn DROP FOREIGN KEY FK_51E4D30F4C493F27');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11456C5646');
        $this->addSql('ALTER TABLE response_score DROP FOREIGN KEY FK_22EFEC01456C5646');
        $this->addSql('ALTER TABLE response_yn DROP FOREIGN KEY FK_51E4D30F456C5646');
        $this->addSql('ALTER TABLE response_qcm DROP FOREIGN KEY FK_CA5224DF9D1C3019');
        $this->addSql('ALTER TABLE response_qcm DROP FOREIGN KEY FK_CA5224DFFBF32840');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11613FECDF');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F613FECDF');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8FFB08EDF6');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575BEFD98D1');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4A76ED395');
        $this->addSql('DROP TABLE civility');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE eval_question');
        $this->addSql('DROP TABLE eval_score');
        $this->addSql('DROP TABLE eval_yn');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE response_qcm');
        $this->addSql('DROP TABLE response_score');
        $this->addSql('DROP TABLE response_yn');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE trainer');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE user');
    }
}
