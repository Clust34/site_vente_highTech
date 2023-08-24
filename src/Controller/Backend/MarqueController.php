<?php

namespace App\Controller\Backend;

use App\Entity\Marque;
use App\Form\MarqueForm;
use App\Repository\MarqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/marque', name: 'admin.marque')]
class MarqueController extends AbstractController
{
    public function __construct(
        private MarqueRepository $repoMarque
    ) {
    }

    #[Route('', name: '.index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('Backend/Marques/index.html.twig', [
            'marques' => $this->repoMarque->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response| RedirectResponse
    {
        $marque = new Marque();

        $form = $this->createForm(MarqueForm::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repoMarque->save($marque);
            $this->addFlash('success', 'Marque créée avec succès.');

            return $this->redirectToRoute('admin.marque.index', [
                'form' => $form
            ]);
        }

        return $this->render('Backend/Marques/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ?Marque $marque): Response| RedirectResponse
    {
        if (!$marque instanceof Marque) {
            $this->addFlash('error', 'Marque non trouvé.');

            return $this->redirectToRoute('admin.marque.index');
        }

        $form = $this->createForm(MarqueForm::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->repoMarque->save($marque);
            $this->addFlash('success', 'Marque créée avec succès');

            return $this->redirectToRoute('admin.marque.index');
        }

        return $this->render('Backend/Marques/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Request $request): RedirectResponse
    {
        $marque = $this->repoMarque->find($request->get('id', 0));

        if (!$marque instanceof Marque) {
            $this->addFlash('error', 'Marque non trouvée');

            return $this->redirectToRoute('admin.marque.index');
        }

        if ($this->isCsrfTokenValid('delete' . $marque->getId(), $request->get('token'))) {
            $this->repoMarque->remove($marque);
            $this->addFlash('success', 'Marque supprimée avec succès.');

            return $this->redirectToRoute('admin.marque.index');
        }

        $this->addFlash('error', 'Token invalide');

        return $this->redirectToRoute('admin.marque.index');
    }
}
