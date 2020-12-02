<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201153428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredients (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_9EF68E9C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_ingredients (meal_id INT NOT NULL, ingredients_id INT NOT NULL, INDEX IDX_469A17C7639666D6 (meal_id), INDEX IDX_469A17C73EC4DCE (ingredients_id), PRIMARY KEY(meal_id, ingredients_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE MealTags (meal_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_7F94C9A0639666D6 (meal_id), INDEX IDX_7F94C9A08D7B4FB4 (tags_id), PRIMARY KEY(meal_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE meal_ingredients ADD CONSTRAINT FK_469A17C7639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_ingredients ADD CONSTRAINT FK_469A17C73EC4DCE FOREIGN KEY (ingredients_id) REFERENCES ingredients (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE MealTags ADD CONSTRAINT FK_7F94C9A0639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE MealTags ADD CONSTRAINT FK_7F94C9A08D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C12469DE2');
        $this->addSql('ALTER TABLE meal_ingredients DROP FOREIGN KEY FK_469A17C73EC4DCE');
        $this->addSql('ALTER TABLE meal_ingredients DROP FOREIGN KEY FK_469A17C7639666D6');
        $this->addSql('ALTER TABLE MealTags DROP FOREIGN KEY FK_7F94C9A0639666D6');
        $this->addSql('ALTER TABLE MealTags DROP FOREIGN KEY FK_7F94C9A08D7B4FB4');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE meal_ingredients');
        $this->addSql('DROP TABLE MealTags');
        $this->addSql('DROP TABLE tags');
    }
}
