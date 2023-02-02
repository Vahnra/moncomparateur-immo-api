<?php

namespace App\Controller;

use App\Entity\Favorites;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FavoritesController extends AbstractController
{
    #[Route('/api/favorites/add', name: 'addFavorites', methods:['POST'])]
    public function addFavorite(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializerInterface, ValidatorInterface $validator): JsonResponse
    {
        $decoded = json_decode($request->getContent());

        // $test = $serializerInterface->deserialize($request->getContent(), Favorites::class, 'json');

        $favorite = new Favorites();
        $favorite->setUser($this->getUser());
        $favorite->setDpeNumber($decoded->dpeNumber);
        $favorite->setDpeDate($decoded->dpeDate);
        $favorite->setDpeClass($decoded->dpeClass);
        $favorite->setAdress($decoded->adress);
        $favorite->setBuildingType($decoded->buildingType);
        $favorite->setAreaSize($decoded->areaSize);
        $favorite->setLatitude($decoded->latitude);
        $favorite->setLongitude($decoded->longitude);

        $errors = $validator->validate($favorite);

        if (count($errors) > 0) {
            return $this->json(['error' => 'Une erreur est survenu']);
        }

        $entityManager->persist($favorite);
        $entityManager->flush();

        return $this->json([
            'message' => 'Le favoris a bien été ajouté',
        ]);
    }

    #[Route('/api/favorites/update', name: 'updateFavorites', methods:['PUT'])]
    public function updateFavorite(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializerInterface, ValidatorInterface $validator): JsonResponse
    {
        
        return $this->json([
            'message' => 'Le favoris a bien été modifié',
        ]);
    }

    #[Route('/api/favorites/delete', name: 'deleteFavorites', methods:['DELETE'])]
    public function deleteFavorite(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializerInterface, ValidatorInterface $validator): JsonResponse
    {
        
        return $this->json([
            'message' => 'Le favoris a bien été modifié',
        ]);
    }
}
