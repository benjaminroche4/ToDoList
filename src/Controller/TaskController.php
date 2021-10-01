<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Form\UpdateTaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    /**
     * Show task not done
     * (First method to select)
     * @Route("/tasks", name="app_task")
     */
    public function notDone(): Response
    {
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();

        return $this->render('task/notdone.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show task done
     * (Second method to select)
     * @Route("/tasks/done", name="app_task_done")
     */
    public function isDone(): Response
    {
        $tasksDone = $this->getDoctrine()->getRepository(Task::class)->findBy(['is_done'=>'1']);

        return $this->render('task/isdone.html.twig', [
            'tasksDone' => $tasksDone
        ]);
    }


    /**
     * Add task
     * @Route("/tasks/add", name="app_add_task")
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

    /**
     * Delete task
     * @Route("/tasks/delete/{id}", name="app_task_delete")
     */
    public function delete(Task $task, EntityManagerInterface $entityManager): Response
    {
        if($this->getUser() == $task->getUser()) {
            $entityManager->remove($task);
            $entityManager->flush();

            $this->addFlash('notification', 'La tâche a bien été supprimée !');
            return $this->redirectToRoute("app_task");
        }
        else {
            $this->addFlash('notification_error', 'Vous n\'avez pas l\'autorisation de supprimer cette tache');
            return $this->redirectToRoute('app_task');
        }
    }

    /**
     * Update task
     * @Route("/tasks/update/{id}", name="app_task_update")
     */
    public function updateTask(Task $task, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateTaskType::class, $task);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()) {
            $task->setTitle($form->get('title')->getData());
            $task->setContent($form->get('content')->getData());
            $task->setIsDone($form->get('is_done')->getData());

            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('notification', 'La tâche a bien été modifié.');
            return $this->redirectToRoute('app_task_update', ['id'=>$task->getId()]);
        }

            return $this->render('task/update.html.twig', [
                'form' => $form->createView(),
                'task' => $task
        ]);
    }

    /**
     * Toggle task
     * @Route("/tasks/toggle/{id}", name="app_task_toggle")
     */
    public function toggleTask(Task $task): Response
    {
        $task->setIsDone(1);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('notification', 'La tâche a bien été terminée !');
        return $this->redirectToRoute('app_task');
    }
}
