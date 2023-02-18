<?php

namespace App\Controller;

use App\Entity\Order;
use DateTime;
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

        $userId = $this->getUser()->getId();
        $typeAbonnement = $decoded->type;

        if ($decoded->type == 1) {
            $typeAbonnement = "monthly";
        }


        if ($decoded->type == 2) {
            $typeAbonnement = "annual";
        }

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
        $mollie->setApiKey("test_F544S6H8yT3KuehA8uyNH333pP42Bb");

        $existingCustomer = $entityManager->getRepository(Order::class)->findOneBy(['user' => $this->getUser()]);

        if (!$existingCustomer) {

            $customer = $mollie->customers->create([
                "name" => $this->getUser()->getUsername(),
                "email" => $this->getUser()->getEmail(),
            ]);
    
            $payment = $customer->createPayment([
                "amount" => [
                    "value" => $price, // You must send the correct number of decimals, thus we enforce the use of strings
                    "currency" => "EUR",
                ],
                "description" => "First payment - Order #{$orderId}",
                "redirectUrl" => 'http://localhost:4200/user/' . $userId . '/dashboard',
                "webhookUrl" => "https://orn-chanarong.fr/api/web-hook-payment",
                "metadata" => [
                    "order_id" => $orderId,
                ],
        
                // Flag this payment as a first payment to allow recurring payments later.
                "sequenceType" => \Mollie\Api\Types\SequenceType::SEQUENCETYPE_FIRST,
            ]);

        } else {

            $customer = $mollie->customers->get($existingCustomer->getCustomerId());

            $payment = $customer->createPayment([
                "amount" => [
                    "value" => $price, // You must send the correct number of decimals, thus we enforce the use of strings
                    "currency" => "EUR",
                ],
                "description" => "First payment - Order #{$orderId}",
                "redirectUrl" => 'http://localhost:4200/user/' . $userId . '/dashboard',
                "webhookUrl" => "https://orn-chanarong.fr/api/web-hook-payment",
                "metadata" => [
                    "order_id" => $orderId,
                ],
        
                // Flag this payment as a first payment to allow recurring payments later.
                "sequenceType" => \Mollie\Api\Types\SequenceType::SEQUENCETYPE_FIRST,
            ]);

        }
        
        
        $order = new Order;
        $order->setCreatedAt(new DateTime());
        $order->setCustomerId($customer->id);
        $order->setPrice($price);
        $order->setType($typeAbonnement);
        $order->setUser($this->getUser());
        $order->setOrderId($orderId);
        $order->setStatus($payment->status);

        $entityManager->persist($order);
        $entityManager->flush();

        return new JsonResponse($payment->getCheckoutUrl(), Response::HTTP_OK, []);
    }

    #[Route('/api/payment/cancel-subscription', name: 'cancel_subscription', methods:['POST'])]
    public function cancelSubscription(Order $payment, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $mollie = new MollieApiClient();
        $mollie->setApiKey("test_F544S6H8yT3KuehA8uyNH333pP42Bb");

        $order = $entityManager->getRepository(Order::class)->findOneBy(['user' => $this->getUser(), 'subscriptionStatus' => 'active'], ['id' => 'DESC']);

        $customer = $mollie->customers->get($order->getCustomerId());
        $subscription = $customer->cancelSubscription($order->getSubscriptionId());

        $order->setSubscriptionStatus($subscription->status);
        $entityManager->persist($order);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_OK, []);
    }

    #[Route('/api/web-hook-payment', name: 'update_order_payment_status', methods:['POST'])]
    public function updateOrderPaymentStats(Order $payment, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $mollie = new MollieApiClient();
        $mollie->setApiKey("test_F544S6H8yT3KuehA8uyNH333pP42Bb");
        
        $payment = $mollie->payments->get($request->get('id'));
        $orderId = $payment->metadata->order_id;

        $order = $entityManager->getRepository(Order::class)->findOneBy(['orderId' => $orderId]);

        $order->setStatus($payment->status);

        if ($payment->isPaid() && ! $payment->hasRefunds() && ! $payment->hasChargebacks()) {
            $currentUser = $order->getUser();
            $currentUser->setStatus('paid');
            $entityManager->persist($currentUser);

            $customer = $mollie->customers->get($order->getCustomerId());

            if ($order->getType() == 'monthly') {

                $dt2 = new DateTime("+1 month");
                $date = $dt2->format("Y-m-d");

                $subscription = $customer->createSubscription([
                    "amount" => [
                            "currency" => "EUR",
                            "value" => $order->getPrice(),
                    ],
                    "startDate" => $date,
                    "interval" => "1 months",
                    "description" => "Monthly payment",
                    "webhookUrl" => "https://orn-chanarong.fr/api/web-hook-subscription",
                ]);

                $order->setSubscriptionId($subscription->id);
                $order->setSubscriptionStatus($subscription->status);
                $order->setSubStartDate($subscription->startDate);
         
            }

            if ($order->getType() == 'annual') {
                $dt2 = new DateTime("+1 year");
                $date = $dt2->format("Y-m-d");
                $subscription = $customer->createSubscription([
                    "amount" => [
                            "currency" => "EUR",
                            "value" => $order->getPrice(),
                    ],
                    "startDate" => $date,
                    "interval" => "12 months",
                    "description" => "Annual payment",
                    "webhookUrl" => "https://orn-chanarong.fr/api/web-hook-subscription",
                ]);

                $order->setSubscriptionId($subscription->id);
                $order->setSubscriptionStatus($subscription->status);
                $order->setSubStartDate($subscription->startDate);
            }

        } elseif ($payment->isOpen()) {
            /*
             * The payment is open.
             */
        } elseif ($payment->isPending()) {
            /*
             * The payment is pending.
             */
        } elseif ($payment->isFailed()) {
            /*
             * The payment has failed.
             */
        } elseif ($payment->isExpired()) {
            /*
             * The payment is expired.
             */
        } elseif ($payment->isCanceled()) {
            /*
             * The payment has been canceled.
             */
        } elseif ($payment->hasRefunds()) {
            /*
             * The payment has been (partially) refunded.
             * The status of the payment is still "paid"
             */
        } elseif ($payment->hasChargebacks()) {
            /*
             * The payment has been (partially) charged back.
             * The status of the payment is still "paid"
             */
        }

        $entityManager->persist($order);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_OK, []);
    }

    #[Route('/api/web-hook-subscription', name: 'update_order_subscription_status', methods:['POST'])]
    public function updateOrderSubscriptionStats(Order $payment, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $mollie = new MollieApiClient();
        $mollie->setApiKey("test_F544S6H8yT3KuehA8uyNH333pP42Bb");
        
        $subscription = $mollie->subscriptions->get($request->get('id'));
        $subscriptionId = $subscription->metadata->subscription_id;

        $order = $entityManager->getRepository(Order::class)->findOneBy(['subscriptionId' => $subscriptionId]);

        $order->setSubscriptionStatus($subscription->status);
        $entityManager->persist($order);
        
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_OK, []);
    }
}
