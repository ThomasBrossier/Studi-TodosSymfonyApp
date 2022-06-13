<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Entity\Todoslists;
use App\Form\TasksType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TasksController extends AbstractController
{
    #[Route('/create-task/{id}', name: 'create_task')]
    public function createTask(Request $request,EntityManagerInterface $em, Todoslists $list): Response
    {
        $task = new Tasks;
        $form = $this->createForm(TasksType::class,$task);
        $form->handleRequest($request);

        if($form-> isSubmitted() && $form-> isValid()){
           $task->setList($list);
           $task->setDone(0);
           $em->persist($task);
           $em->flush();
           return $this->redirectToRoute("todos_lists");
        }
        return $this->render('tasks/create.html.twig', [
            'controller_name' => 'TasksController',
            "form"=> $form->createView()
        ]);
    }

    #[Route('/delete-task/{id}', name: 'delete_task')]
    public function deleteTask(EntityManagerInterface $em, Tasks $task): Response
    {
           $em->remove($task);
           $em->flush();
           return $this->redirectToRoute("todos_lists");
    }

    #[Route('/update-task/{id}', name: 'update_task')]
    public function update(Tasks $task, Request $request,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TasksType::class,$task);
        $form->handleRequest($request);
        if($form-> isSubmitted() && $form-> isValid()){
           $em->flush();
           return $this->redirectToRoute("todos_lists");
        }
        return $this->render('tasks/create.html.twig', [
            'controller_name' => 'updateTaskController',
            "form"=> $form->createView(),
            'task'=> $task
        ]);
    }
}
