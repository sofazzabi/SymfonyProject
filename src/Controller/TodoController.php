<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todos')]
    public function index(Request $request): Response
    {   $session = $request->getSession();
        if (!$session->has('todos')){
            $todos = array(
            'achat'=>'acheter clé usb',
            'cours'=>'finaliser mon cours',
            'correction'=>'corriger mes examens'

            );

            $session->set('todos',$todos);
            $this->addFlash('info',"la liste des todos vient d'etre créee");
        }
        return $this->render('todo/index.html.twig');
    }

    #[Route('/todo/add/{name}/{content}', name: 'todo.add')]
    public  function addTodo(Request $request , $name, $content):RedirectResponse{
        $session = $request->getSession();
        if ($session->has('todos')){
            $todos = $session->get('todos');
            if (isset($todos[$name])){
                $this->addFlash('error',"le todo d'id $name existe déjà dans la liste");

            }
            else {
                $todos[$name] = $content;
                $this->addFlash('success',"le todo d'id $name a été ajouté avec succès");
                $session->set('todos',$todos);

            }


        }
        else {
            $this->addFlash('error',"la liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_todos');




    }

    #[Route('/todo/update/{name}/{content}', name: 'todo.update')]
    public  function updateTodo(Request $request , $name, $content):RedirectResponse{
        $session = $request->getSession();
        if ($session->has('todos')){
            $todos = $session->get('todos');
            if (!isset($todos[$name])){
                $this->addFlash('error',"le todo d'id $name n'existe pas dans la liste");

            }
            else {
                $todos[$name] = $content;
                $this->addFlash('success',"le todo d'id $name a été modifié avec succès");
                $session->set('todos',$todos);

            }


        }
        else {
            $this->addFlash('error',"la liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_todos');




    }

    #[Route('/todo/delete/{name}', name: 'todo.delete')]
    public  function deleteTodo(Request $request , $name):RedirectResponse{
        $session = $request->getSession();
        if ($session->has('todos')){
            $todos = $session->get('todos');
            if (!isset($todos[$name])){
                $this->addFlash('error',"le todo d'id $name n'existe pas dans la liste");

            }
            else {
                unset($todos[$name]);
                $this->addFlash('success',"le todo d'id $name a été supprimé avec succès");
                $session->set('todos',$todos);

            }


        }
        else {
            $this->addFlash('error',"la liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_todos');




    }
    #[Route('/todo/reset', name: 'todo.reset')]
    public  function resetTodo(Request $request ):RedirectResponse{
        $session = $request->getSession();
        if ($session->has('todos')){
            $session->remove('todos');
        }
        else {
            $this->addFlash('error',"La session n'existe pas'");
        }

        return $this->redirectToRoute('app_todos');




    }
}
