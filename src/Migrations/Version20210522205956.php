<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210522205956 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE code ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE code ALTER email DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER phone DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER email DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE code ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE code ALTER email DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" DROP user_id');
        $this->addSql('ALTER TABLE "user" ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER phone DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER email DROP DEFAULT');
    }
}
