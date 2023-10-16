<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231005102648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier ADD nom_produit_panier VARCHAR(255) NOT NULL, ADD prix_produit_panier NUMERIC(5, 2) NOT NULL, ADD type_produit_panier VARCHAR(255) NOT NULL, ADD image_produit_panier VARCHAR(255) NOT NULL, ADD quantite_produit_panier INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP nom_produit_panier, DROP prix_produit_panier, DROP type_produit_panier, DROP image_produit_panier, DROP quantite_produit_panier');
    }
}
