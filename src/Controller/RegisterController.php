<?php


namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $passwordHasher;
    private $entityManager;
    private $validator;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        // Récupérer les données d'inscription de la requête
        $data = json_decode($request->getContent(), true);

        // Vérifier si l'adresse e-mail existe déjà dans la base de données
        $userRepository = $this->entityManager->getRepository(User::class);
        $existingUser = $userRepository->findOneBy(['email' => $data['email']]);

        if ($existingUser) {
            // L'adresse e-mail existe déjà, renvoyez une réponse d'erreur
            return new JsonResponse(['message' => 'Adresse e-mail déjà enregistrée'], 400);
        }

        // Créer une nouvelle instance d'utilisateur
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPrenomUser($data['prenomUser']);
        $user->setRoles(['ROLE_USER']); 

        // Hasher le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Valider l'entité User
        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            return new JsonResponse(['message' => 'Validation des données échouée', 'errors' => $errors], 400);
        }

        // Enregistrer l'utilisateur dans la base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Répondre avec un message de réussite
        return new JsonResponse(['message' => 'Inscription réussie'], 201);
    }
}