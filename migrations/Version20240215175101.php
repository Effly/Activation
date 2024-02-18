<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215175101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, contract_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D34A04AD2576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE contract ADD limit_date DATETIME NOT NULL, ADD is_pay TINYINT(1) NOT NULL, ADD cost DOUBLE PRECISION DEFAULT NULL, ADD amount_of_insurance DOUBLE PRECISION DEFAULT NULL, ADD period_day INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2576E0FD');
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE contract DROP limit_date, DROP is_pay, DROP cost, DROP amount_of_insurance, DROP period_day');
    }
}
