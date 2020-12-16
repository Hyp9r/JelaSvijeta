<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206134034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE MealTags DROP FOREIGN KEY FK_7F94C9A0639666D6');
        $this->addSql('ALTER TABLE MealTags DROP FOREIGN KEY FK_7F94C9A08D7B4FB4');
        $this->addSql('ALTER TABLE MealTags ADD CONSTRAINT FK_7F94C9A0639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
        $this->addSql('ALTER TABLE MealTags ADD CONSTRAINT FK_7F94C9A08D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE MealTags DROP FOREIGN KEY FK_7F94C9A0639666D6');
        $this->addSql('ALTER TABLE MealTags DROP FOREIGN KEY FK_7F94C9A08D7B4FB4');
        $this->addSql('ALTER TABLE MealTags ADD CONSTRAINT FK_7F94C9A0639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE MealTags ADD CONSTRAINT FK_7F94C9A08D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
    }
}
