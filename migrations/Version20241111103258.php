<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241111103258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membres DROP FOREIGN KEY FK_594AE39CFE19A1A8');
        $this->addSql('DROP TABLE gradecouleur');
        $this->addSql('DROP INDEX IDX_594AE39CFE19A1A8 ON membres');
        $this->addSql('ALTER TABLE membres ADD grade VARCHAR(255) DEFAULT NULL, ADD roles VARCHAR(255) NOT NULL, DROP grade_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gradecouleur (id INT AUTO_INCREMENT NOT NULL, couleur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE membres ADD grade_id INT NOT NULL, DROP grade, DROP roles');
        $this->addSql('ALTER TABLE membres ADD CONSTRAINT FK_594AE39CFE19A1A8 FOREIGN KEY (grade_id) REFERENCES gradecouleur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_594AE39CFE19A1A8 ON membres (grade_id)');
    }
}
