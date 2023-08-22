<?php

namespace App\Controller\Backend;

use App\Entity\Tablettes;
use App\Form\TabletteForm;
use App\Repository\TablettesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/tablettes', name: 'admin.tablettes')]
class TablettesController extends AbstractController
{
    public function __construct(
        private TablettesRepository $repoTab
    ) {
    }

    #[Route('', name: '.index', methods: ['POST', 'GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Tablettes/index.html.twig', [
            'tablettes' => $this->repoTab->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['POST', 'GET'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $tablette = new Tablettes();

        $form = $this->createForm(TabletteForm::class, $tablette);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->repoTab->save($tablette);
            $this->addFlash('success', 'Article tablette créé avec succès.');

            return $this->redirectToRoute('admin.tablettes.index');
        }

        return $this->render('Backend/Tablettes/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(?Tablettes $tablette, Request $request): Response
    {
        if (!$tablette instanceof Tablettes) {
            $this->addFlash('error', 'Tablettes non trouvé');

            return $this->redirectToRoute('admin.tablettes.index');
        }
        $form = $this->createForm(TabletteForm::class, $tablette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->repoTab->save($tablette);
            $this->addFlash('success', 'Article tablettes créé avec succès');

            return $this->redirectToRoute('admin.tablettes.index');
        }

        return $this->render('Backend/Tablettes/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Request $request): RedirectResponse
    {
        $tablette = $this->repoTab->find($request->get('id', 0));

        if (!$tablette instanceof Tablettes) {
            $this->addFlash('error', 'Tablettes non trouvé');

            return $this->redirectToRoute('admin.tablettes.index');
        }

        if ($this->isCsrfTokenValid('delete' . $tablette->getId(), $request->get('token'))) {
            $this->repoTab->remove($tablette);
            $this->addFlash('success', 'Tablette supprimé avec succès');

            return $this->redirectToRoute('admin.tablettes.index');
        }

        $this->addFlash('error', 'Token invalide');

        return $this->redirectToRoute('admin.tablettes.index');
    }
}
