<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328095701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson ADD hours_end TIME NOT NULL, CHANGE students_max_numbers number_max_of_students INT NOT NULL, CHANGE end_time time_end DATE NOT NULL, CHANGE time_slot hours_start TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson ADD time_slot TIME NOT NULL, DROP hours_start, DROP hours_end, CHANGE number_max_of_students students_max_numbers INT NOT NULL, CHANGE time_end end_time DATE NOT NULL');
    }
}
