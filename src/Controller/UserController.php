<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    #[Route('/api/user', name: 'app_user')]
    // #[IsGranted('ROLE_USER', message: 'Vous n\'avez pas les droits suffisants')]
    public function index(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $usersList=$userRepository->findAll();
        $jsonUserList = $serializer->serialize($usersList, 'json', ['groups' => 'getUsers']);
        
        return new JsonResponse($jsonUserList, Response::HTTP_OK,[], true);
    }

    #[Route('/api/user/{id}',name:"app_detail_user",methods:['GET'])]
    #[IsGranted('ROLE_USER', message: 'Vous n\'avez pas les droits suffisants')]
    public function getDetailPanier(User $user, SerializerInterface $serializer): JsonResponse{

        // Assurez-vous que l'utilisateur connecté a accès à ses propres données
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit d\'accéder à ces données.');
        }
      
        $jsonUser = $serializer->serialize($user,'json', ['groups' => 'getPaniers']);
        return new JsonResponse($jsonUser, Response::HTTP_OK,['accept'=>'json'],true);
    }

//     #[Route('/panier/{id}', name: 'app_delete_panier', methods: ['DELETE'])]
//     public function deletePanier(Panier $panier, EntityManagerInterface $em): JsonResponse 
//     {
//         $em->remove($panier);
//         $em->flush();
//         return new JsonResponse(null, Response::HTTP_NO_CONTENT);
//     }

//     #[Route('/panier/{id}', name:"app_update_panier", methods:['PUT'])]
//    public function updatePanier(Request $request, SerializerInterface $serializer, Panier $currentPanier, EntityManagerInterface $em): JsonResponse 
//    {
//        $updatedPanier = $serializer->deserialize($request->getContent(), 
//                Panier::class, 
//                'json', 
//                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentPanier]);
       
//        $em->persist($updatedPanier);
//        $em->flush();
//        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
//   }
}
