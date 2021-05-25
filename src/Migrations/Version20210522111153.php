<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210522111153 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE shop_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE shop (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN shop.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN shop.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN shop.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE article ADD title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE article ADD body TEXT NOT NULL');
        $this->addSql('ALTER TABLE article ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE article ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN article.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN article.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN article.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE card ADD pan_token VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE card ADD cardholder VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE card ADD expiration_year VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE card ADD expiration_month VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE code ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE code ALTER email DROP DEFAULT');
        $this->addSql('ALTER TABLE comment ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE comment ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD text TEXT NOT NULL');
        $this->addSql('COMMENT ON COLUMN comment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN comment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN comment.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
        $this->addSql('ALTER TABLE goods DROP CONSTRAINT fk_563b92da76ed395');
        $this->addSql('DROP INDEX idx_563b92da76ed395');
        $this->addSql('ALTER TABLE goods ADD order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE goods ADD cost INT NOT NULL');
        $this->addSql('ALTER TABLE goods ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE goods ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE goods ADD colors VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE goods ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE goods ADD structure VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE goods ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE goods ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE goods RENAME COLUMN user_id TO shop_id');
        $this->addSql('ALTER TABLE goods ADD CONSTRAINT FK_563B92D4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE goods ADD CONSTRAINT FK_563B92D8D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_563B92D4D16C4DD ON goods (shop_id)');
        $this->addSql('CREATE INDEX IDX_563B92D8D9F6D38 ON goods (order_id)');
        $this->addSql('ALTER TABLE "order" ADD shop_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" ADD completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" ADD sum INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD status VARCHAR(255) NOT NULL');
        $this->addSql('COMMENT ON COLUMN "order".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "order".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "order".completed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993984D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F52993984D16C4DD ON "order" (shop_id)');
        $this->addSql('ALTER TABLE transaction ADD order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD sum INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD payout_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD status VARCHAR(255) NOT NULL');
        $this->addSql('COMMENT ON COLUMN transaction.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN transaction.payout_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D18D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D18D9F6D38 ON transaction (order_id)');
        $this->addSql('ALTER TABLE "user" ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER phone DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER email DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE goods DROP CONSTRAINT FK_563B92D4D16C4DD');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993984D16C4DD');
        $this->addSql('DROP SEQUENCE shop_id_seq CASCADE');
        $this->addSql('DROP TABLE shop');
        $this->addSql('ALTER TABLE article DROP title');
        $this->addSql('ALTER TABLE article DROP body');
        $this->addSql('ALTER TABLE article DROP created_at');
        $this->addSql('ALTER TABLE article DROP updated_at');
        $this->addSql('ALTER TABLE article DROP deleted_at');
        $this->addSql('ALTER TABLE card DROP pan_token');
        $this->addSql('ALTER TABLE card DROP cardholder');
        $this->addSql('ALTER TABLE card DROP expiration_year');
        $this->addSql('ALTER TABLE card DROP expiration_month');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C7294869C');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('ALTER TABLE comment DROP article_id');
        $this->addSql('ALTER TABLE comment DROP created_at');
        $this->addSql('ALTER TABLE comment DROP updated_at');
        $this->addSql('ALTER TABLE comment DROP deleted_at');
        $this->addSql('ALTER TABLE comment DROP text');
        $this->addSql('ALTER TABLE goods DROP CONSTRAINT FK_563B92D8D9F6D38');
        $this->addSql('DROP INDEX IDX_563B92D4D16C4DD');
        $this->addSql('DROP INDEX IDX_563B92D8D9F6D38');
        $this->addSql('ALTER TABLE goods ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE goods DROP shop_id');
        $this->addSql('ALTER TABLE goods DROP order_id');
        $this->addSql('ALTER TABLE goods DROP cost');
        $this->addSql('ALTER TABLE goods DROP name');
        $this->addSql('ALTER TABLE goods DROP quantity');
        $this->addSql('ALTER TABLE goods DROP colors');
        $this->addSql('ALTER TABLE goods DROP description');
        $this->addSql('ALTER TABLE goods DROP structure');
        $this->addSql('ALTER TABLE goods DROP type');
        $this->addSql('ALTER TABLE goods DROP status');
        $this->addSql('ALTER TABLE goods ADD CONSTRAINT fk_563b92da76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_563b92da76ed395 ON goods (user_id)');
        $this->addSql('DROP INDEX IDX_F52993984D16C4DD');
        $this->addSql('ALTER TABLE "order" DROP shop_id');
        $this->addSql('ALTER TABLE "order" DROP created_at');
        $this->addSql('ALTER TABLE "order" DROP updated_at');
        $this->addSql('ALTER TABLE "order" DROP completed_at');
        $this->addSql('ALTER TABLE "order" DROP sum');
        $this->addSql('ALTER TABLE "order" DROP status');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D18D9F6D38');
        $this->addSql('DROP INDEX UNIQ_723705D18D9F6D38');
        $this->addSql('ALTER TABLE transaction DROP order_id');
        $this->addSql('ALTER TABLE transaction DROP created_at');
        $this->addSql('ALTER TABLE transaction DROP sum');
        $this->addSql('ALTER TABLE transaction DROP payout_date');
        $this->addSql('ALTER TABLE transaction DROP status');
        $this->addSql('ALTER TABLE code ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE code ALTER email DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER phone DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER email DROP DEFAULT');
    }
}
