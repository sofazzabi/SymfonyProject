<?php

namespace App\Controller;

use App\Entity\Personne;

use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('personne')]

class PersonneController extends AbstractController
{#[Route('/' , name: 'personne.list')]
    public function index(ManagerRegistry $doctrine) : Response {
$repository = $doctrine->getRepository(Personne::class);
$personnes = $repository->findAll();
return $this->render('personne/index1.html.twig',[
    'personnes'=> $personnes
]);

}

    #[Route('/{id<\d+>}' , name: 'personne.detail')]
    public function detail(ManagerRegistry $doctrine , $id) : Response {
        $repository = $doctrine->getRepository(Personne::class);
        $personne = $repository->find($id);
        if (!$personne){
            $this->addFlash('error' , "la personne d'id $id n'existe pas");
            return $this->redirectToRoute('personne.list');

        }

        return $this->render('personne/index.html.twig',[
            'personne'=> $personne
        ]);

    }


    #[Route('/add', name: 'app_personne')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $entityManagaer = $doctrine->getManager();
//        $personne = new Personne();
//        $personne->setFirstname('Amin');
//        $personne->setName('Azzabi');
//        $personne->setAge(29);
//        //$entityManagaer = $doctrine->getManager();
////        $personne2 = new Personne();
////        $personne2->setFirstname('Ammin');
////        $personne2->setName('Azzabi');
////        $personne2->setAge(29);
//
//        $entityManagaer->persist($personne);
////        $entityManagaer->persist($personne2);
//      $entityManagaer->flush();


        return $this->render('personne/index.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route('/all/{page?1}/{nbre?15}' , name: 'personne.list.all')]
    public function indexAll(ManagerRegistry $doctrine , $page , $nbre) : Response {
        $repository = $doctrine->getRepository(Personne::class);
        $limit = ($page - 1) * $nbre;
        $nbPersonne = $repository->count([]);
        $nbrePage =   ceil ($nbPersonne / $nbre );

        $personnes = $repository->findBy([],[],$nbre,$limit);
        return $this->render('personne/index1.html.twig',[
            'personnes'=> $personnes,
            'isPaginated'=>true,
            'nbrePage'=>$nbrePage,
            'page' =>$page,
            'nbre' =>$nbre

        ]);

    }
     #[Route('/delete/{id}' , name: 'personne.delete' )]
    public function DeletePersonne(Personne $personne = null ,ManagerRegistry $doctrine  ) : RedirectResponse{
    if ($personne){
        $manager = $doctrine->getManager();
        $manager->remove($personne);
        $manager->flush();
        $this->addFlash('success' , "La personne a été supprimée avec succès");
    }
    else {
        $this->addFlash('error' , "personne inexistante");

    }
    return $this->redirectToRoute('personne.list.all');


}

#[Route('/update/{id}/{name}/{firstname}/{age}' , name:'personne.update')]
public function updatePersonne(Personne $personne = null , $name , $firstname , $age,ManagerRegistry $doctrine) :RedirectResponse  {
    if ($personne){
        $personne->setName($name);
        $personne->setFirstname($firstname);
        $personne->setAge($age);
        $manager = $doctrine->getManager();
        $manager->persist($personne);
        $manager->flush();;
    }
    else {
        $this->addFlash('error' , "personne inexistante");

    }
    return $this->redirectToRoute('personne.list.all');

}

#[Route('/all/age/{ageMin}/{ageMax}' , name: 'personne.list.age')]
public function personnesByAge(ManagerRegistry $doctrine , $ageMin,$ageMax) : Response {
    $repository = $doctrine->getRepository(Personne::class);
    $personnes = $repository->findPersonneByAgeInterval($ageMin,$ageMax);
    return $this->render('personne/index1.html.twig',[
        'personnes'=> $personnes
    ]);

}

    #[Route('/stats/age/{ageMin}/{ageMax}' , name: 'personne.stats.age')]
    public function statspersonnesByAge(ManagerRegistry $doctrine , $ageMin,$ageMax) : Response {
        $repository = $doctrine->getRepository(Personne::class);
        $stats = $repository->statsPersonneByAgeInterval($ageMin,$ageMax);
        return $this->render('personne/stats.html.twig',[
            'stats'=> $stats[0],
            'ageMin'=>$ageMin,
            'ageMax'=>$ageMax
        ]);

    }


    #[Route('/add/form', name: 'app_form_personne',)]
    public function addPersonneForm(ManagerRegistry $doctrine,Request $request): Response
    {

        $personne = new Personne();

        $form = $this->createForm(PersonneType::class,$personne);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $managaer = $doctrine->getManager();
            $managaer->persist($personne);
            $managaer->flush();
            return $this->redirectToRoute('personne.list');





        }
        else {
            return $this->render('personne/add-personne.html.twig', [
                'form'=>$form->createView()

            ]);

        }







    }

}
