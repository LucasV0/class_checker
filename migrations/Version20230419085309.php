<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20230419085309.php
final class Version20230419085309 extends AbstractMigration
========
final class Version20230424091923 extends AbstractMigration
>>>>>>>> 0e35023242d8dae1be1e0e36d3cb4b43c47a0f1a:migrations/Version20230424091923.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, lessons_id INT NOT NULL, students_id INT NOT NULL, justify_id INT NOT NULL, date_justify DATE NOT NULL, INDEX IDX_765AE0C9FED07355 (lessons_id), INDEX IDX_765AE0C91AD8D010 (students_id), INDEX IDX_765AE0C9133D3755 (justify_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE justify (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, period_id INT NOT NULL, label VARCHAR(255) NOT NULL, number_max_of_students INT NOT NULL, time_start DATE NOT NULL, time_end DATE NOT NULL, hours_start TIME NOT NULL, hours_end TIME NOT NULL, day VARCHAR(255) NOT NULL, INDEX IDX_F87474F341807E1D (teacher_id), INDEX IDX_F87474F3EC8B7ADE (period_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE period (id INT AUTO_INCREMENT NOT NULL, period_start DATE NOT NULL, period_end DATE NOT NULL, session VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, birthday DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE to_have (id INT AUTO_INCREMENT NOT NULL, students_id INT NOT NULL, lessons_id INT NOT NULL, INDEX IDX_3590FB8F1AD8D010 (students_id), INDEX IDX_3590FB8FFED07355 (lessons_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(350) NOT NULL, auth_code VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(350) NOT NULL, prenom VARCHAR(350) NOT NULL, telephone VARCHAR(350) NOT NULL, sexe VARCHAR(350) NOT NULL, date_naissance DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9FED07355 FOREIGN KEY (lessons_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C91AD8D010 FOREIGN KEY (students_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9133D3755 FOREIGN KEY (justify_id) REFERENCES justify (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F341807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3EC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id)');
        $this->addSql('ALTER TABLE to_have ADD CONSTRAINT FK_3590FB8F1AD8D010 FOREIGN KEY (students_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE to_have ADD CONSTRAINT FK_3590FB8FFED07355 FOREIGN KEY (lessons_id) REFERENCES lesson (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9FED07355');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C91AD8D010');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9133D3755');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F341807E1D');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3EC8B7ADE');
        $this->addSql('ALTER TABLE to_have DROP FOREIGN KEY FK_3590FB8F1AD8D010');
        $this->addSql('ALTER TABLE to_have DROP FOREIGN KEY FK_3590FB8FFED07355');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE justify');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE to_have');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
