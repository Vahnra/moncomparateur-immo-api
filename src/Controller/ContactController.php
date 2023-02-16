<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use JMS\Serializer\SerializerInterface as JMSSerializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/api/contact', name: 'add_contact', methods:['POST'])]
    public function addContact(Contact $contact, SerializerInterface $serializer, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $newContact = $serializer->deserialize($request->getContent(), Contact::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $contact]);

        if ($newContact) {
            $newContact->setUser($this->getUser());

            $errorsNewContact = $validator->validate($newContact);
            if (count($errorsNewContact) > 0) {
                return new JsonResponse($errorsNewContact, Response::HTTP_BAD_REQUEST, []);
            }

            $entityManager->persist($newContact);
            $entityManager->flush();

            return new JsonResponse('success', Response::HTTP_OK, []);
        }

        return new JsonResponse(null , Response::HTTP_BAD_REQUEST, []);
    }

    #[Route('/api/contact', name: 'get_user_contacts', methods:['GET'])]
    public function getUserContacts(Contact $contact, JMSSerializer $JSMSerializer, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $userContacts = $entityManager->getRepository(Contact::class)->findBy(['user' => $this->getUser()]);

        if ($userContacts) {
            $jsonAllContacts = $JSMSerializer->serialize($userContacts, 'json', SerializationContext::create()->setGroups(array('getContacts')));

            return new JsonResponse($jsonAllContacts, Response::HTTP_OK, [], true);
        }
       
        return new JsonResponse(null , Response::HTTP_BAD_REQUEST, []);
    }
}
