<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'register', methods:['POST'])]
    public function register(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator): Response
    {
          
        $em = $doctrine->getManager();
        $decoded = json_decode($request->getContent());
        $email = $decoded->email;
        $plaintextPassword = $decoded->password;
        $postalCode = $decoded->postalCode;
        $birthdayDate = $decoded->birthdayDate;
        $company = $decoded->company;
        $phoneNumbers = $decoded->phoneNumbers;
        $username = $decoded->username;

        $dobReconverted = \DateTime::createFromFormat('Y-m-d', $birthdayDate); 
  
        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPostalCode($postalCode);
        $user->setBirthdayDate($dobReconverted);
        $user->setCompany($company);
        $user->setPhoneNumbers($phoneNumbers);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $this->json(['error' => 'Email non valide']);
        }

        $em->persist($user);
        $em->flush();
  
        return $this->json(['message' => 'Registered Successfully']);
    }
}
