<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabCotroller extends AbstractController
{
    #[Route('/tab/{nb<\d+>?5}', name: 'tab')]
    public function index($nb): Response
    {    $notes = [];
        for ($i = 0;$i<$nb;$i++){
            $notes[] = rand(0,20);
        }
        return $this->render('tab_cotroller/index.html.twig', [
            'notes' => $notes,
        ]);
    }
    #[Route('/tab/users', name: 'tab.users')]
    public function users(): Response{
        $users = [
            ['firstname' =>'aymen','name' =>'selaaouti','age'=>39],
        ['firstname' =>'ali','name' =>'ali','age'=>58],
        ['firstname' =>'imed','name' =>'omda','age'=>12]
        ];
        return $this->render('tab/users.html.twig',[
            'users'=>$users
        ]);

    }
}
