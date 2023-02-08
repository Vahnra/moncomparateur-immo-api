<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comment;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use JMS\Serializer\SerializerInterface as JMSSerializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    #[Route('/api/project/add', name: 'add_project', methods:['POST'])]
    public function addProject(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $decoded = json_decode($request->getContent());

        $project = new Project();
        $project->setType($decoded->type);
        $project->setCity($decoded->city);
        $project->setCity($decoded->city);
        $project->setAdress($decoded->adress);
        $project->setComplementAdress($decoded->complementAdress);
        $project->setUser($this->getUser());
        $project->setCreatedAt(new DateTime());
        $project->setUpdatedAt(new DateTime());

        if ($decoded->comments) {
            $comment = new Comment;
            $comment->setText($decoded->comments);
            $comment->setUser($this->getUser());
            $comment->setProject($project);
            $comment->setCreatedAt(new DateTime());
            $comment->setUpdatedAt(new DateTime());

            $project->addComment($comment);
        }

        $errorsProject = $validator->validate($project);
        $errorsComment = $validator->validate($comment);

        if (count($errorsProject) > 0 || count($errorsComment) > 0) {
            return new JsonResponse($errorsProject, Response::HTTP_BAD_REQUEST, []);
        }
        
        $entityManager->persist($project);
        $entityManager->persist($comment);
        $entityManager->flush();

        $serialized = $serializer->serialize($project, 'json', ['groups' => 'getProject']);

        return new JsonResponse($serialized, Response::HTTP_OK, []);
    }

    #[Route('/api/project/all-project', name: 'get_all_project', methods:['GET'])]
    public function getAllProject(EntityManagerInterface $entityManager, JMSSerializer $JSMSerializer): JsonResponse
    {
        $allProjects = $entityManager->getRepository(Project::class)->findAll();

        $jsonAllProject = $JSMSerializer->serialize($allProjects, 'json', SerializationContext::create()->setGroups(array('getProject')));

        return new JsonResponse($jsonAllProject, Response::HTTP_OK, []);
    }

    #[Route('/api/project/user-projects', name: 'get_user_projects', methods:['GET'])]
    public function getUserProjects(EntityManagerInterface $entityManager, JMSSerializer $JSMSerializer): JsonResponse
    {
        $userProjects = $entityManager->getRepository(Project::class)->findBy(['user' => $this->getUser()]);

        $jsonUserProject = $JSMSerializer->serialize($userProjects, 'json', SerializationContext::create()->setGroups(array('getProject')));

        return new JsonResponse($jsonUserProject, Response::HTTP_OK, [], true);
    }

    #[Route('/api/project/{id}', name: 'get_project', methods:['GET'])]
    public function getProject(string $id, EntityManagerInterface $entityManager, SerializerInterface $SymfonySerializer, Request $request, JMSSerializer $JSMSerializer): JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->findOneBy(['id' => $id]);

        if ($project) {
            $jsonProject = $JSMSerializer->serialize($project, 'json');
            return new JsonResponse($jsonProject, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/project/{id}', name: 'update_project', methods:['PUT'])]
    public function updateProject(Project $project, EntityManagerInterface $entityManager, SerializerInterface $SymfonySerializer, Request $request): JsonResponse
    {
        $updatedProject = $SymfonySerializer->deserialize($request->getContent(), Project::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $project]);

        $entityManager->persist($updatedProject);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/project/{id}', name: 'delete_project', methods:['DELETE'])]
    public function deleteProject(Project $project, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($project);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
