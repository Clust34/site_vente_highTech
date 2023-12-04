<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/users', name: 'admin.users')]
class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $repo,
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        // test git
        return $this->render('Backend/User/index.html.twig', [
            'users' => $this->repo->findAll()
        ]);
    }

    #[Route('/edit/{id}', name: '.update', methods: ['GET', 'POST'])]
    public function update(?User $user, Request $request): Response|RedirectResponse
    {
        // Verifie que le user existe
        if (!$user instanceof User) {
            $this->addFlash('error', 'Utilisateur non trouvé');

            return $this->redirectToRoute('admin.users.index');
        }

        // Créer et instancie le form
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Verifie le form et enregistre
        if ($form->isSubmitted() && $form->isValid()) {
            $this->repo->save($user);
            $this->addFlash('success', 'Utilisateur mofié avec succès.');

            return $this->redirectToRoute('admin.users.index');
        }

        return $this->render('Backend/User/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Request $request): RedirectResponse
    {
        // Trouve le bon utilisateur
        $user = $this->repo->find($request->request->get('id', 0));

        // On vérifie qu'il existe
        if (!$user instanceof User) {
            $this->addFlash('error', "L'utilisateur n'as pas été trouvé.");

            return $this->redirectToRoute('admin.users.index');
        }

        // On supprime le user
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('token'))) {
            if ($user === $this->getUser()) {
                $this->addFlash('error', 'Vous ne pouvez pas supprimer un compte qui est actuellement connecté.');

                return $this->redirectToRoute('admin.users.index');
            }

            // On peut supprimer
            $this->repo->remove($user);
            $this->addFlash('success', 'Compte supprimer avec succès.');

            return $this->redirectToRoute('admin.users.index');
        }

        // Sinon
        $this->addFlash('error', 'Token invalide');

        return $this->redirectToRoute('admin.users.index');
    }
}
