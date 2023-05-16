<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516125608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, students_id INT NOT NULL, justify_id INT NOT NULL, session_id INT NOT NULL, date_justify DATE NOT NULL, INDEX IDX_765AE0C91AD8D010 (students_id), INDEX IDX_765AE0C9133D3755 (justify_id), INDEX IDX_765AE0C9613FECDF (session_id), UNIQUE INDEX clee (students_id, session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE justify (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, period_id INT NOT NULL, label VARCHAR(255) NOT NULL, number_max_of_students INT NOT NULL, time_start DATE NOT NULL, time_end DATE NOT NULL, hours_start TIME NOT NULL, hours_end TIME NOT NULL, day VARCHAR(255) NOT NULL, INDEX IDX_F87474F341807E1D (teacher_id), INDEX IDX_F87474F3EC8B7ADE (period_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE period (id INT AUTO_INCREMENT NOT NULL, period_start DATE NOT NULL, period_end DATE NOT NULL, session VARCHAR(255) NOT NULL, current_period TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, lesson_id INT NOT NULL, date DATE NOT NULL, hour_start TIME NOT NULL, hour_end TIME NOT NULL, label VARCHAR(255) NOT NULL, day VARCHAR(255) NOT NULL, INDEX IDX_D044D5D4CDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, birthday DATE NOT NULL, verif_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE to_have (id INT AUTO_INCREMENT NOT NULL, students_id INT NOT NULL, lessons_id INT NOT NULL, INDEX IDX_3590FB8F1AD8D010 (students_id), INDEX IDX_3590FB8FFED07355 (lessons_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(350) NOT NULL, auth_code VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(350) NOT NULL, prenom VARCHAR(350) NOT NULL, telephone VARCHAR(350) NOT NULL, sexe VARCHAR(350) NOT NULL, date_naissance DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C91AD8D010 FOREIGN KEY (students_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9133D3755 FOREIGN KEY (justify_id) REFERENCES justify (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F341807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3EC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE to_have ADD CONSTRAINT FK_3590FB8F1AD8D010 FOREIGN KEY (students_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE to_have ADD CONSTRAINT FK_3590FB8FFED07355 FOREIGN KEY (lessons_id) REFERENCES lesson (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C91AD8D010');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9133D3755');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9613FECDF');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F341807E1D');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3EC8B7ADE');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4CDF80196');
        $this->addSql('ALTER TABLE to_have DROP FOREIGN KEY FK_3590FB8F1AD8D010');
        $this->addSql('ALTER TABLE to_have DROP FOREIGN KEY FK_3590FB8FFED07355');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE justify');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE to_have');
        $this->addSql('DROP TABLE user');
    }
}
