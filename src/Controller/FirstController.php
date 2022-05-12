<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig',[
            'name'=>'Azzabi',
            'firstname'=>'Sofiene'

        ]);
    }


    #[Route('/sayHello/{name}', name: 'say.Hello ')]
    public function sayHello(Request $request,$name): Response
    {   //dd($request);
        return  $this->render('first/hello.html.twig',['nom'=>$name]);
    }
    //on peut gérer les expressions régulières avec regexer(site internet)
    #[Route('/multi/{entier1}/{entier2}',
    name:'multiplication', requirements: ['entier1'=>'\d+','entier2'=>'\d+']
    )]
    public function multiplication($entier1 , $entier2){
        $res = $entier1 * $entier2;
        return new Response("<h1>$res</h1>");


    }
    #[Route('/template', name: 'template')]
    public function template(): Response
    {
        return $this->render('template.html.twig');
    }

}


