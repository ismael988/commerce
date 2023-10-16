<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $produitRepository, SerializerInterface $serializer): JsonResponse
    {
        $produitsList=$produitRepository->findAll();
        $jsonProduitList = $serializer->serialize($produitsList, 'json', ['groups' => 'getPaniers']);
        
        return new JsonResponse($jsonProduitList, Response::HTTP_OK,[], true);
    }

    #[Route('/produit/{id}',name:"app_detail_produit",methods:['GET'])]
    public function getDetailProduit(Produit $produit, SerializerInterface $serializer): JsonResponse{

        $jsonProduit = $serializer->serialize($produit,'json', ['groups' => 'getPaniers']);
        return new JsonResponse($jsonProduit, Response::HTTP_OK,['accept'=>'json'],true);
    }

    #[Route('/produit/type/{type}',name:"app_type_produit",methods:['GET'])]
    public function getProduitsByType(string $type, ProduitRepository $produitRepository): JsonResponse{
       
        $produits = $produitRepository->findBy(['typeProduit' => $type]);
        
        return $this->json($produits, Response::HTTP_OK, [], ['groups' => 'getPaniers']);
    }

}
