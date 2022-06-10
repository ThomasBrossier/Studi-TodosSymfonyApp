<?php

namespace App\Controller;

use App\Entity\Todoslists;
use App\Form\TodosListsType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosListsController extends AbstractController
{
    #[Route('/', name: 'app_todos_lists')]
    public function index(): Response
    {
        return $this->render('todos_lists/index.html.twig', [
            'controller_name' => 'TodosListsController',
        ]);
    }
    #[Route('/create-list', name: 'app_create_lists')]
    public function create(Request $request,EntityManagerInterface $em): Response
    {
        $todosList = new Todoslists;
        $form = $this->createForm(TodosListsType::class,$todosList);
        $form->handleRequest($request);

        if($form-> isSubmitted() && $form-> isValid()){
           $em->persist($todosList);
           $em->flush();
        }
        return $this->render('todos_lists/create.html.twig', [
            'controller_name' => 'createListController',
            "form"=> $form->createView()
        ]);
    }
}
