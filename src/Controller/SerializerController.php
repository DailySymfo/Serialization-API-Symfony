<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerController extends AbstractController
{
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user=$user;
        
    }
    
    
    #[Route('/getAllUser', name: 'all_user', methods:'GET')]
    public function getAllUser(): Response
    {
        $users=$this->user->findAll(); //Object


         //Normalizer

        $normalizer=new ObjectNormalizer(); // Pour transformer l'object en un array


        //encoder

        $encoder= new JsonEncoder();// On peut choisir l'encoder que l'on veut (XML,CSV etc...)

        //Serializer

        $serializer= new Serializer([$normalizer], [$encoder]);

        $usersJson=$serializer->serialize($users,'json');

        $response=new Response($usersJson);

        return $response;
    }



    #[Route('/getOneUser/{id}', name: 'one_user', methods:"GET")]
    public function getOneUser($id): Response
    {
        $user=$this->user->find($id);

         //Normalizer

         $normalizer=new ObjectNormalizer(); // Pour transformer l'object en un array


         //encoder
 
         $encoder= new JsonEncoder();// On peut choisir l'encoder que l'on veut (XML,CSV etc...)
 
         //Serializer
 
         $serializer= new Serializer([$normalizer], [$encoder]);

 
         $userJson=$serializer->serialize($user,'json');

         
         $response=new Response($userJson);

          return $response;
    }




    // Validation ou Selection via le Context

    #[Route('/getSomeUserFields/{id}', name: 'some_user_fields', methods:"GET")]
    public function getSomeUserFields($id): Response
    {
        $user=$this->user->find($id);

         //Normalizer

         $normalizer=new ObjectNormalizer(); // Pour transformer l'object en un array


         //encoder
 
         $encoder= new JsonEncoder();// On peut choisir l'encoder que l'on veut (XML,CSV etc...)
 
         //Serializer
 
         $serializer= new Serializer([$normalizer], [$encoder]);

         //Utilisation du Context
         $userJson=$serializer->serialize($user,'json',[AbstractNormalizer::IGNORED_ATTRIBUTES=>['telephone','password']]);

         
         $response=new Response($userJson);

          return $response;
    }





}
