<?php

namespace App\Controller;

use App\Entity\Dvf;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use JMS\Serializer\SerializerInterface as JMSSerializer;

class DvfController extends AbstractController
{
    #[Route('/api/dvf', name: 'get_dvf')]
    public function getDvf(EntityManagerInterface $entityManager, Request $request, JMSSerializer $JSMSerializer): JsonResponse
    {
        $number = $request->get('number');
        $street = $request->get('street');
        $city = $request->get('city');
        $type = $request->get('type');

        $dvf = $entityManager->getRepository(Dvf::class)->findOneBy(['adresseNomVoie' => $street, 'adresseNumero' => $number, 'typeLocal' => $type]);
        
        if ($dvf) {
            $jsonDvf = $JSMSerializer->serialize($dvf, 'json');
            return new JsonResponse($jsonDvf, Response::HTTP_OK, [], true);
        }
        

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
