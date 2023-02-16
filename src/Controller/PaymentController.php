<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Mollie\Api\MollieApiClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Mollie\Api\Resources\Payment;

class PaymentController extends AbstractController
{
    #[Route('/api/payment', name: 'add_order')]
    public function addOrder(Order $payment, EntityManagerInterface $entityManager): JsonResponse
    {
        $orderId = time();

        $mollie = new MollieApiClient();
        $mollie->setApiKey("test_fxypAGNWGrb54W9zagd4FuUtQMKgnn");
        
        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => "18.99", // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Order #{$orderId}",
            "redirectUrl" => "https://localhost:4200/user/3/payment",
            "webhookUrl" => "https://localhost:4200/user/3/payment",
            "metadata" => [
                "order_id" => $orderId,
            ],
        ]);

        
        $order = new Order;
        $order->setUser($this->getUser());
        $order->setOrderId($orderId);
        $order->setStatus($payment->status);

        $entityManager->persist($order);
        $entityManager->flush();

        return new JsonResponse($payment->getCheckoutUrl(), Response::HTTP_OK, []);
    }
}
