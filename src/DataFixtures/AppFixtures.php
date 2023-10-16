<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Paiement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'une vingtaine de produits

            // Liste de types  aléatoires
         $type = ['Légumes', 'Fruits', 'Produits frais', 'Epicerie', 'Boisson'];

            // Génération aléatoire du type de produits
        for ($i = 1; $i < 21; $i++) {
             $produit = new Produit();
             $produit->setNomProduit('Produit ' . $i);
             $produit->setPrixProduit($i);
             $produit->setQuantiteproduit($i);
             $produit->setImageproduit('image ' . $i);
             $randomTypeIndex = array_rand($type);
             $produit->setTypeProduit($type[$randomTypeIndex]);
             $manager->persist($produit);
         }

        // Création d'une vingtaine de paniers

            // Liste de types  aléatoires
        $typeProduitPanier = ['Légumes', 'Fruits', 'Produits frais', 'Epicerie', 'Boisson'];

            // Génération aléatoire du type de produits
        for ($i = 1; $i < 21; $i++) {
            $panier = new Panier();
            $panier->setPrixPanier($i);
            $panier->setNomProduitPanier('Produit ' . $i);
            $panier->setPrixProduitPanier($i);
            $panier->setQuantiteproduitPanier($i);
            $panier->setImageProduitPanier('image ' . $i);
            $randomTypeIndex = array_rand($type);
            $panier->setTypeProduitPanier($typeProduitPanier[$randomTypeIndex]);
            $manager->persist($panier);
        }

        // Création d'une vingtaine de paiements
        for ($i = 1; $i < 21; $i++) {
            $paiement = new Paiement();
            $datePaiement= new DateTime('1980-08-01'); // Exemple de date de naissance
            $datePaiement->modify('+' . $i . ' years'); // Ajouter $i années à la date de naissance
            $paiement->setdatePaiement($datePaiement);
            $paiement -> setMontantPaiement($i);
            $manager->persist($paiement);
        }

        // Liste de noms et prénoms aléatoires
        $prenoms = ['Jean', 'Pierre', 'Marie', 'Sophie', 'Claire', 'Luc'];

        // Création de 7 Users
        for ($i = 1; $i < 7; $i++) {
            $user = new User();

            // Génération aléatoire du nom et prénom en utilisant la fonction "array_rand"
            $randomPrenomIndex = array_rand($prenoms);
            $user->setPrenomUser($prenoms[$randomPrenomIndex]);


            $user->setRoles(['ROLE_USER']);
            $user->setEmail('user' . $i . '@exemple.com');

            // Utilisation de UserPasswordHasherInterface pour hacher le mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();

    }
}