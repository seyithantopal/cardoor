<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191221231353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, userid INT DEFAULT NULL, carid INT DEFAULT NULL, pickupdate DATETIME DEFAULT NULL, returndate DATETIME DEFAULT NULL, status TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car CHANGE category_id category_id INT DEFAULT NULL, CHANGE title title VARCHAR(100) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE keywords keywords VARCHAR(255) DEFAULT NULL, CHANGE image image VARCHAR(100) DEFAULT NULL, CHANGE star star INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE fuel fuel VARCHAR(50) DEFAULT NULL, CHANGE doors doors INT DEFAULT NULL, CHANGE gearbox gearbox VARCHAR(20) DEFAULT NULL, CHANGE abs abs TINYINT(1) DEFAULT NULL, CHANGE airbag airbag TINYINT(1) DEFAULT NULL, CHANGE bluetooth bluetooth TINYINT(1) DEFAULT NULL, CHANGE carkit carkit TINYINT(1) DEFAULT NULL, CHANGE gps gps TINYINT(1) DEFAULT NULL, CHANGE remote_start remote_start TINYINT(1) DEFAULT NULL, CHANGE parking_cameras parking_cameras TINYINT(1) DEFAULT NULL, CHANGE music music TINYINT(1) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE userid userid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE title title VARCHAR(100) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE comment CHANGE comment comment VARCHAR(255) DEFAULT NULL, CHANGE carid carid INT DEFAULT NULL, CHANGE userid userid INT DEFAULT NULL, CHANGE rate rate INT DEFAULT NULL, CHANGE ip ip VARCHAR(20) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE faq CHANGE question question VARCHAR(255) DEFAULT NULL, CHANGE answer answer VARCHAR(255) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE image CHANGE car_id car_id INT DEFAULT NULL, CHANGE title title VARCHAR(100) DEFAULT NULL, CHANGE image image VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE message CHANGE name name VARCHAR(50) DEFAULT NULL, CHANGE email email VARCHAR(50) DEFAULT NULL, CHANGE subject subject VARCHAR(50) DEFAULT NULL, CHANGE message message VARCHAR(255) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE setting CHANGE title title VARCHAR(100) DEFAULT NULL, CHANGE description description VARCHAR(100) DEFAULT NULL, CHANGE keywords keywords VARCHAR(100) DEFAULT NULL, CHANGE company company VARCHAR(100) DEFAULT NULL, CHANGE address address VARCHAR(100) DEFAULT NULL, CHANGE phone phone VARCHAR(30) DEFAULT NULL, CHANGE email email VARCHAR(20) DEFAULT NULL, CHANGE smtpserver smtpserver VARCHAR(100) DEFAULT NULL, CHANGE smtpemail smtpemail VARCHAR(100) DEFAULT NULL, CHANGE smtppassword smtppassword VARCHAR(100) DEFAULT NULL, CHANGE smtpport smtpport VARCHAR(50) DEFAULT NULL, CHANGE facebook facebook VARCHAR(100) DEFAULT NULL, CHANGE instagram instagram VARCHAR(100) DEFAULT NULL, CHANGE twitter twitter VARCHAR(100) DEFAULT NULL, CHANGE aboutus aboutus VARCHAR(255) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE name name VARCHAR(50) DEFAULT NULL, CHANGE lastname lastname VARCHAR(50) DEFAULT NULL, CHANGE image image VARCHAR(100) DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cart');
        $this->addSql('ALTER TABLE car CHANGE category_id category_id INT DEFAULT NULL, CHANGE title title VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE keywords keywords VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE image image VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE star star INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\', CHANGE fuel fuel VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE doors doors INT DEFAULT NULL, CHANGE gearbox gearbox VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE abs abs TINYINT(1) DEFAULT \'NULL\', CHANGE airbag airbag TINYINT(1) DEFAULT \'NULL\', CHANGE bluetooth bluetooth TINYINT(1) DEFAULT \'NULL\', CHANGE carkit carkit TINYINT(1) DEFAULT \'NULL\', CHANGE gps gps TINYINT(1) DEFAULT \'NULL\', CHANGE remote_start remote_start TINYINT(1) DEFAULT \'NULL\', CHANGE parking_cameras parking_cameras TINYINT(1) DEFAULT \'NULL\', CHANGE music music TINYINT(1) DEFAULT \'NULL\', CHANGE status status TINYINT(1) DEFAULT \'NULL\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\', CHANGE userid userid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE title title VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status TINYINT(1) DEFAULT \'NULL\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE comment CHANGE comment comment VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE carid carid INT DEFAULT NULL, CHANGE userid userid INT DEFAULT NULL, CHANGE rate rate INT DEFAULT NULL, CHANGE ip ip VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status TINYINT(1) DEFAULT \'NULL\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE faq CHANGE question question VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE answer answer VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status TINYINT(1) DEFAULT \'NULL\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE image CHANGE car_id car_id INT DEFAULT NULL, CHANGE title title VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE image image VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE message CHANGE name name VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE subject subject VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE message message VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status TINYINT(1) DEFAULT \'NULL\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE setting CHANGE title title VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE description description VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE keywords keywords VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE company company VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE address address VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE phone phone VARCHAR(30) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(20) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE smtpserver smtpserver VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE smtpemail smtpemail VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE smtppassword smtppassword VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE smtpport smtpport VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE facebook facebook VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE instagram instagram VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE twitter twitter VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE aboutus aboutus VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE name name VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE lastname lastname VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE image image VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE status status TINYINT(1) DEFAULT \'NULL\', CHANGE created_at created_at DATETIME DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
    }
}
