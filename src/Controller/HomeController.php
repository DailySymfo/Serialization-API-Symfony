<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user=$user;
    }
    

    
    #[Route('/getAllUsers', name: 'all_users', methods:'GET')]
    public function getAllUser(): Response
    {
        $users=$this->user->findAll();


        return $this->json($users,200);
    }



    #[Route('/getOneUsers/{id}', name: 'one_users', methods:"GET")]
    public function getOneUser($id): Response
    {
        $user=$this->user->find($id);

        return $this->json($user,200);
    }


    
    
    // Validator ou selector Attributes  Groups
    

    #[Route('/getUsers', name: 'user_all', methods:"GET")]
    public function getUsers(): Response
    {
        $user=$this->user->findAll();

        return $this->json($user,200,[], ['groups'=>'monGroup2']);
    }





    // Json sans besoin de validator ou Selector


    #[Route('/getSomeUsersFields/{id}', name: 'some_users_fields', methods:"GET")]
        public function getSomeUsersFields($id): Response
        {
            $user=$this->user->find($id);

            return new JsonResponse(

                [
                    'user_id'=>$user->getId(),
                    'user_email'=>$user->getEmail(),
                    'user_nom'=>$user->getNom(),
                    'user_telephone'=>$user->getTelephone()
                ]
            );
        }


}
