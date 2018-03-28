<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180328185757 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE metropolitan_city (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE municipality ADD metropolitan_city_id INT DEFAULT NULL, ADD license_plate_code VARCHAR(2) NOT NULL');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F56628857B1101 FOREIGN KEY (metropolitan_city_id) REFERENCES metropolitan_city (id)');
        $this->addSql('CREATE INDEX IDX_C6F56628857B1101 ON municipality (metropolitan_city_id)');
        $this->addSql('ALTER TABLE province ADD is_abolished TINYINT(1) NOT NULL, DROP license_plate_code');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE municipality DROP FOREIGN KEY FK_C6F56628857B1101');
        $this->addSql('DROP TABLE metropolitan_city');
        $this->addSql('DROP INDEX IDX_C6F56628857B1101 ON municipality');
        $this->addSql('ALTER TABLE municipality DROP metropolitan_city_id, DROP license_plate_code');
        $this->addSql('ALTER TABLE province ADD license_plate_code VARCHAR(2) NOT NULL COLLATE utf8mb4_unicode_ci, DROP is_abolished');
    }
}
