<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191130133608 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car ADD detail LONGTEXT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE title title VARCHAR(100) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE keywords keywords VARCHAR(255) DEFAULT NULL, CHANGE image image VARCHAR(100) DEFAULT NULL, CHANGE star star INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE fuel fuel VARCHAR(50) DEFAULT NULL, CHANGE doors doors INT DEFAULT NULL, CHANGE gearbox gearbox VARCHAR(20) DEFAULT NULL, CHANGE abs abs TINYINT(1) DEFAULT NULL, CHANGE airbag airbag TINYINT(1) DEFAULT NULL, CHANGE bluetooth bluetooth TINYINT(1) DEFAULT NULL, CHANGE carkit carkit TINYINT(1) DEFAULT NULL, CHANGE gps gps TINYINT(1) DEFAULT NULL, CHANGE remote_start remote_start TINYINT(1) DEFAULT NULL, CHANGE parking_cameras parking_cameras TINYINT(1) DEFAULT NULL, CHANGE music music TINYINT(1) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE title title VARCHAR(100) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP detail, CHANGE category_id category_id INT DEFAULT NULL, CHANGE title title VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE keywords keywords VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE image image VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE star star INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\', CHANGE fuel fuel VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE doors doors INT DEFAULT NULL, CHANGE gearbox gearbox VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE abs abs TINYINT(1) DEFAULT \'NULL\', CHANGE airbag airbag TINYINT(1) DEFAULT \'NULL\', CHANGE bluetooth bluetooth TINYINT(1) DEFAULT \'NULL\', CHANGE carkit carkit TINYINT(1) DEFAULT \'NULL\', CHANGE gps gps TINYINT(1) DEFAULT \'NULL\', CHANGE remote_start remote_start TINYINT(1) DEFAULT \'NULL\', CHANGE parking_cameras parking_cameras TINYINT(1) DEFAULT \'NULL\', CHANGE music music TINYINT(1) DEFAULT \'NULL\', CHANGE status status TINYINT(1) DEFAULT \'NULL\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE category CHANGE title title VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status TINYINT(1) DEFAULT \'NULL\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
    }
}
