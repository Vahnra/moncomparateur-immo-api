<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use JMS\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializer;

class UserController extends AbstractController
{
    #[Route('/api/user', name: 'get_users', methods:['GET'])]
    public function getUsers(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $allUsers = $entityManager->getRepository(User::class)->findAll();

        $jsonAllUsers = $serializer->serialize($allUsers, 'json', SerializationContext::create()->setGroups(array('getUsers')));

        return new JsonResponse($jsonAllUsers, Response::HTTP_OK, [], true);
    }

    #[Route('/api/user/{id}', name: 'get_detail_user', methods:['GET'])]
    public function getDetailUser(string $id, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        if ($user) {
            $jsonDetailUser = $serializer->serialize($user, 'json');
            return new JsonResponse($jsonDetailUser, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/user/{id}', name: 'update_user', methods:['PUT'])]
    public function updateUser(User $user, EntityManagerInterface $entityManager, SymfonySerializer $SymfonySerializer, Request $request): JsonResponse
    {
        $updatedUser = $SymfonySerializer->deserialize($request->getContent(), User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        $entityManager->persist($updatedUser);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/user/{id}', name: 'delete_user', methods:['DELETE'])]
    public function deleteUser(User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/current-user', name: 'current_user', methods:['GET'])]
    public function currentUser(User $user, EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer): JsonResponse
    {
        $userId = $this->getUser();  
        
        if ($userId) {
            $jsonDetailUser = $serializer->serialize($userId, 'json');
            return new JsonResponse($jsonDetailUser, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/stats-user', name: 'stats_user', methods:['GET'])]
    public function statsUser(User $user, EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer): JsonResponse
    {    
        $test = [];

        array_push($test, count($entityManager->getRepository(Project::class)->findBy(['user' => $this->getUser(), 'status' => 'prospection'])));

        array_push($test, count($entityManager->getRepository(Project::class)->findBy(['user' => $this->getUser(), 'status' => 'estimation'])));

        array_push($test, count($entityManager->getRepository(Project::class)->findBy(['user' => $this->getUser(), 'status' => 'mandat'])));

        array_push($test, count($entityManager->getRepository(Project::class)->findBy(['user' => $this->getUser(), 'status' => 'visite'])));

        array_push($test, count($entityManager->getRepository(Project::class)->findBy(['user' => $this->getUser(), 'status' => 'contre-visite'])));

        return new JsonResponse($test, Response::HTTP_OK, []);
    }

}
