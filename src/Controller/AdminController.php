<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\UpdateUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * Admin panel
     * @Route("/admin", name="app_admin")
     */
    public function allUsers(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/panel.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Delete user
     * @Route("/admin/delete/{id}", name="app_admin_delete")
     */
    public function deleteUser(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('notification', 'L\'utilisateur a bien été supprimé');
        return $this->redirectToRoute("app_admin");
    }

    /**
     * Update user
     * @Route("/admin/update/{id}", name="app_admin_update")
     */
    public function updateUser(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setRoles($form->get('roles')->getData());
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('notification', 'L\'utilisateur a bien été mis à jour');
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/update.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
