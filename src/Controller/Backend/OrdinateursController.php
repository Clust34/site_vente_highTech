<?php

namespace App\Controller\Backend;

use App\Entity\Ordinateurs;
use App\Form\OrdinateurForm;
use App\Repository\OrdinateursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/ordinateurs', name: 'admin.ordinateurs')]
class OrdinateursController extends AbstractController
{
    public function __construct(
        private OrdinateursRepository $repoOrdi
    ) {
    }

    #[Route('', name: '.index', methods: ['POST', 'GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Ordinateurs/index.html.twig', [
            'ordinateurs' => $this->repoOrdi->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['POST', 'GET'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $ordinateur = new Ordinateurs();

        $form = $this->createForm(OrdinateurForm::class, $ordinateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->repoOrdi->save($ordinateur);
            $this->addFlash('success', 'Article ordinateur créé avec succès.');

            return $this->redirectToRoute('admin.ordinateurs.index');
        }

        return $this->render('Backend/Ordinateurs/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(?Ordinateurs $ordinateur, Request $request): Response
    {
        if (!$ordinateur instanceof Ordinateurs) {
            $this->addFlash('error', 'Ordinateurs non trouvé');

            return $this->redirectToRoute('admin.ordinateurs.index');
        }
        $form = $this->createForm(OrdinateurForm::class, $ordinateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->repoOrdi->save($ordinateur);
            $this->addFlash('success', 'Article ordinateurs créé avec succès');

            return $this->redirectToRoute('admin.ordinateurs.index');
        }

        return $this->render('Backend/Ordinateurs/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Request $request): RedirectResponse
    {
        $ordinateur = $this->repoOrdi->find($request->get('id', 0));

        if (!$ordinateur instanceof Ordinateurs) {
            $this->addFlash('error', 'Tablettes non trouvé');

            return $this->redirectToRoute('admin.ordinateurs.index');
        }

        if ($this->isCsrfTokenValid('delete' . $ordinateur->getId(), $request->get('token'))) {
            $this->repoOrdi->remove($ordinateur);
            $this->addFlash('success', 'Ordinateur supprimé avec succès');

            return $this->redirectToRoute('admin.ordinateurs.index');
        }

        $this->addFlash('error', 'Token invalide');

        return $this->redirectToRoute('admin.ordinateurs.index');
    }

    #[Route('/switch/{id}', name: '.switch', methods: ['GET'])]
    public function switch(?Ordinateurs $ordinateur): JsonResponse
    {
        if (!$ordinateur instanceof Ordinateurs) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Tablette non trouvée.',
            ], 404);
        }

        $ordinateur->setActif(!$ordinateur->isActif());

        $this->repoOrdi->save($ordinateur);

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Tablette mise à jour avec succès.',
            'enable' => $ordinateur->isActif(),
        ], 201);
    }
}
