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
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends AbstractController
{
    #[Route('/api/payment', name: 'add_order')]
    public function addOrder(Order $payment, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $decoded = json_decode($request->getContent());

        switch ([$decoded->option, $decoded->type]) {
            case ['0', '1']:
                $price = '18.99';
            break;
        
            case ['0', '2'];
                $price = '227.88';
            break;

            case ['1', '1']:
                $price = '23.98';
            break;
        
            case ['1', '2'];
                $price = '244.80';
            break;
        
            case ['2', '1'];
                $price = '26.98';
            break;
        
            case ['2', '2'];
                $price = '275.16';
            break;

            case ['3', '1'];
                $price = '29.97';
            break;
        
            case ['3', '2'];
                $price = '305.64';
            break;

            case ['4', '1'];
                $price = '32.96';
            break;
        
            case ['4', '2'];
                $price = '336.24';
            break;

            case ['5', '1'];
                $price = '35.95';
            break;
        
            case ['5', '2'];
                $price = '366.72';
            break;

            case ['6', '1'];
                $price = '38.94';
            break;
        
            case ['6', '2'];
                $price = '397.20';
            break;

            case ['7', '1'];
                $price = '41.93';
            break;
        
            case ['7', '2'];
                $price = '427.68';
            break;

            case ['8', '1'];
                $price = '44.92';
            break;
        
            case ['8', '2'];
                $price = '458.16';
            break;

            case ['9', '1'];
                $price = '47.91';
            break;
        
            case ['9', '2'];
                $price = '488.64';
            break;

            case ['10', '1'];
                $price = '50.90';
            break;
        
            case ['10', '2'];
                $price = '519.12';
            break;
        }

    
        $orderId = time();

        $mollie = new MollieApiClient();
        $mollie->setApiKey("test_fxypAGNWGrb54W9zagd4FuUtQMKgnn");
        
        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $price, // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Order #{$orderId}",
            "redirectUrl" => "http://localhost:4200/",
            "webhookUrl" => "http://localhost:4200/user/3/payment",
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

    #[Route('/payment-web-hook', name: 'update_order_payment_status')]
    public function updateOrderPaymentStats(Order $payment, EntityManagerInterface $entityManager): JsonResponse
    {
        $mollie = new MollieApiClient();
        $mollie->setApiKey("test_fxypAGNWGrb54W9zagd4FuUtQMKgnn");
        
        $payment = $mollie->payments->get($_POST["id"]);
        $orderId = $payment->metadata->order_id;

        return new JsonResponse(null, Response::HTTP_OK, []);
    }
}
