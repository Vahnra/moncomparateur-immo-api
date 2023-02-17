<?php

namespace App\Controller;

use App\Entity\Company;
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

       
        if ($decoded->type == false) {
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

            $company = $em->getRepository(Company::class)->findOneBy(['company' => $decoded->company]);

            if ($company) {
                $user->addCompany($company);
            }

            $user->setAccountType($decoded->type);
            $user->setPassword($hashedPassword);
            $user->setEmail($email);
            $user->setRoles(['ROLE_USER']);
            $user->setUsername($username);
            $user->setPostalCode($postalCode);
            $user->setBirthdayDate($dobReconverted);
            $user->setPhoneNumbers($phoneNumbers);
            $user->setAccountType("user");

            $errors = $validator->validate($user);

            if (count($errors) > 0) {
                return $this->json(['error' => 'Email non valide']);
            }

            $em->persist($user);
            $em->flush();
    
            return $this->json(['message' => 'Registered Successfully']);
        }

        if ($decoded->type == true) {
            $email = $decoded->email;
            $plaintextPassword = $decoded->password;
            $postalCode = $decoded->postalCode;
            $phoneNumbers = $decoded->phoneNumbers;
            $username = $decoded->username;

    
            $user = new User();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );

            $user->setPassword($hashedPassword);
            $user->setEmail($email);
            $user->setRoles(['ROLE_USER']);
            $user->setStatus('free');
            $user->setUsername($username);
            $user->setAccountType("agence");
            $user->setPostalCode($postalCode);
            $user->setPhoneNumbers($phoneNumbers);

            $company = new Company;
            $company->setUserAdmin($user);
            $company->addUser($user);
            $company->setAdress($decoded->companyAdress);
            $company->setCity($decoded->companyCity);
            $company->setPostalCode($decoded->postalCode);
            $company->setCompanyCode(uniqid());

            $errors = $validator->validate($user);
            $errorsCompany = $validator->validate($company);

            if (count($errors) > 0) {
                return $this->json(['error' => 'Email non valide']);
            }

            if (count($errorsCompany) > 0) {
                return $this->json(['error' => 'Erreur dans la création de l\'agence']);
            }

            $em->persist($user);
            $em->persist($company);
            $em->flush();
    
            return $this->json(['message' => 'Registered Successfully']);
        }
        
    }
}
