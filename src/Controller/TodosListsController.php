<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosListsController extends AbstractController
{
    #[Route('/todos/lists', name: 'app_todos_lists')]
    public function index(): Response
    {
        return $this->render('todos_lists/index.html.twig', [
            'controller_name' => 'TodosListsController',
        ]);
    }
}
