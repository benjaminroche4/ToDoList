<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    /**
     * First method to select
     * @Route("/task", name="app_task")
     */
    public function notDone(): Response
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();

        return $this->render('task/notdone.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Second method to select
     * @Route("/task/done", name="app_task_done")
     */
    public function isDone(): Response
    {
        $tasksDone = $this->getDoctrine()->getRepository(Task::class)->findBy(['is_done'=>'1']);

        return $this->render('task/isdone.html.twig', [
            'tasksDone' => $tasksDone
        ]);
    }


    /**
     * @Route("/task/add", name="app_add_task")
     */
    public function newTask(TaskRepository $taskRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $task->setUser($this->getUser());
            $task->setCreatedAt(new \DateTimeImmutable());
            $task->setTitle($form->get('title')->getData());
            $task->setContent($form->get('content')->getData());
            $task->setIsDone(0);

            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('notification', 'La tâche a bien été ajouté !');
            return $this->redirectToRoute('app_task');
        }

        return $this->render('task/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
