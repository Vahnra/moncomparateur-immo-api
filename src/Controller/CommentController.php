<?php

namespace App\Controller;

use DateTime;
use App\Entity\Comment;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('/api/project/comment/add{projectId}', name: 'add_comment')]
    public function addComment(string $projectId, EntityManagerInterface $entityManager, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->findOneBy(['id' => $projectId]);

        if ($project) {
            $decoded = json_decode($request->getContent());

            $comment = new Comment;
            $comment->setText($decoded->text);
            $comment->setTitle($decoded->title);
            $comment->setProject($project);
            $comment->setUser($this->getUser());

            $errorsComment = $validator->validate($comment);
            if (count($errorsComment) > 0) {
                return new JsonResponse($errorsComment, Response::HTTP_BAD_REQUEST, []);
            }

            $comment->setCreatedAt(new DateTime());
            $comment->setUpdatedAt(new DateTime());
            $entityManager->persist($comment);
            $entityManager->flush();

            return new JsonResponse(null, Response::HTTP_OK, []);
        }

        return new JsonResponse(null, Response::HTTP_BAD_REQUEST, []);
    }
}
