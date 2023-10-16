<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface; // Importez cette classe
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginController extends AbstractController
{
    private $passwordHasher;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        // Récupérer les données d'authentification de la requête
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];

        // Charger l'utilisateur depuis la base de données
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['message' => 'Identifiants invalides'], 401);
        }

        // L'utilisateur est authentifié avec succès
        return new JsonResponse(['message' => 'Authentification réussie']);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request): Response
    {
        // Vous pouvez ajouter un code personnalisé ici avant la déconnexion
        // Par exemple, journaliser la déconnexion ou effectuer d'autres actions nécessaires

        // Rediriger l'utilisateur vers la page de connexion
        return $this->redirectToRoute('app_login');
    }
}
