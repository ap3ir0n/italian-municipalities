<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180328184202 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE geographical_division (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE municipality (id INT AUTO_INCREMENT NOT NULL, province_id INT DEFAULT NULL, geographical_division_id INT DEFAULT NULL, number INT NOT NULL, name VARCHAR(255) NOT NULL, name_in_other_language VARCHAR(255) NOT NULL, is_provincial_capital TINYINT(1) NOT NULL, cadastral_code VARCHAR(4) NOT NULL, legal_population_at2011 BIGINT NOT NULL, INDEX IDX_C6F56628E946114A (province_id), INDEX IDX_C6F56628F1A61C6B (geographical_division_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, name VARCHAR(255) NOT NULL, license_plate_code VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F56628E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F56628F1A61C6B FOREIGN KEY (geographical_division_id) REFERENCES geographical_division (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE municipality DROP FOREIGN KEY FK_C6F56628F1A61C6B');
        $this->addSql('ALTER TABLE municipality DROP FOREIGN KEY FK_C6F56628E946114A');
        $this->addSql('DROP TABLE geographical_division');
        $this->addSql('DROP TABLE municipality');
        $this->addSql('DROP TABLE province');
    }
}
