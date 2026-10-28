<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261028085354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assignment (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, custom_name VARCHAR(100) NOT NULL, unit_type VARCHAR(255) NOT NULL, customer_order_id INT NOT NULL, unit_id INT NOT NULL, INDEX IDX_30C544BAA15A2E17 (customer_order_id), INDEX IDX_30C544BAF8BD700D (unit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE customer (company_name VARCHAR(255) NOT NULL, phone VARCHAR(20) NOT NULL, address VARCHAR(255) NOT NULL, id INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE intervention_unit (intervention_id INT NOT NULL, unit_id INT NOT NULL, INDEX IDX_D30414918EAE3863 (intervention_id), INDEX IDX_D3041491F8BD700D (unit_id), PRIMARY KEY (intervention_id, unit_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(50) NOT NULL, issue_date DATE NOT NULL, period_start DATE NOT NULL, period_end DATE NOT NULL, amount NUMERIC(10, 2) NOT NULL, status VARCHAR(50) NOT NULL, customer_order_id INT NOT NULL, INDEX IDX_90651744A15A2E17 (customer_order_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, unit_count INT NOT NULL, monthly_price NUMERIC(10, 2) NOT NULL, annual_discount NUMERIC(5, 2) NOT NULL, active TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, order_date DATETIME NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, payment_type VARCHAR(50) NOT NULL, auto_renewal TINYINT NOT NULL, status VARCHAR(50) NOT NULL, total_price NUMERIC(10, 2) NOT NULL, offer_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_F529939853C674EE (offer_id), INDEX IDX_F52993989395C3F3 (customer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, payment_date DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, payment_method VARCHAR(50) NOT NULL, reference VARCHAR(100) NOT NULL, invoice_id INT NOT NULL, INDEX IDX_6D28840D2989F1FD (invoice_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE rack (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(10) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(10) NOT NULL, state VARCHAR(50) NOT NULL, rack_id INT NOT NULL, INDEX IDX_DCBB0C538E86A33E (rack_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, role VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id))');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAA15A2E17 FOREIGN KEY (customer_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_unit ADD CONSTRAINT FK_D30414918EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_unit ADD CONSTRAINT FK_D3041491F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744A15A2E17 FOREIGN KEY (customer_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939853C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C538E86A33E FOREIGN KEY (rack_id) REFERENCES rack (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAA15A2E17');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAF8BD700D');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09BF396750');
        $this->addSql('ALTER TABLE intervention_unit DROP FOREIGN KEY FK_D30414918EAE3863');
        $this->addSql('ALTER TABLE intervention_unit DROP FOREIGN KEY FK_D3041491F8BD700D');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744A15A2E17');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939853C674EE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D2989F1FD');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C538E86A33E');
        $this->addSql('DROP TABLE assignment');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE intervention_unit');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE rack');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
