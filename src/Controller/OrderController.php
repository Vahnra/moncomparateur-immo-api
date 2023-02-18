<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/api/order/user', name: 'get_user_orders', methods:['GET'])]
    public function getUserOrders(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $userOrders = $entityManager->getRepository(Order::class)->findBy(['user' => $this->getUser()], ['createdAt' => 'DESC']);

        if ($userOrders) {

            $jsonAllOrders = $serializer->serialize($userOrders, 'json', SerializationContext::create()->setGroups(array('getOrder')));

            return new JsonResponse($jsonAllOrders, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
