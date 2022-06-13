<?php

namespace App\Controller;

use App\Entity\Todoslists;
use App\Form\TodosListsType;
use App\Repository\TodoslistsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosListsController extends AbstractController
{
    #[Route('/', name: 'todos_lists')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Todoslists::class) ;
        $lists = $repo->findAll();
        return $this->render('todos_lists/index.html.twig', [
            'controller_name' => 'TodosListsController',
            'lists' => $lists
        ]);

    }
    #[Route('/create-list', name: 'create_list')]
    public function create(Request $request,EntityManagerInterface $em): Response
    {
        $todosList = new Todoslists;
        $form = $this->createForm(TodosListsType::class,$todosList);
        $form->handleRequest($request);

        if($form-> isSubmitted() && $form-> isValid()){
           $em->persist($todosList);
           $em->flush();
           return $this->redirectToRoute("todos_lists");
        }
        return $this->render('todos_lists/create.html.twig', [
            'controller_name' => 'createListController',
            "form"=> $form->createView()
        ]);
    }
    #[Route('/update-list/{id}', name: 'update_lists')]
    public function update(Todoslists $list, Request $request,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TodosListsType::class,$list);
        $form->handleRequest($request);
        if($form-> isSubmitted() && $form-> isValid()){
           $em->flush();
           return $this->redirectToRoute("todos_lists");
        }
        return $this->render('todos_lists/create.html.twig', [
            'controller_name' => 'updateListController',
            "form"=> $form->createView(),
            'list'=> $list
        ]);
    }
    #[Route('/delete-list/{id}', name: 'delete')]
    public function delete(Todoslists $list, EntityManagerInterface $em): Response
    {
        $em->remove($list);
        $em->flush();  
        return $this->redirectToRoute("todos_lists");
    }
}
