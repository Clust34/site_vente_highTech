<?php

namespace App\Controller\Backend;

use App\Entity\Telephones;
use App\Form\TelephoneForm;
use App\Repository\TelephonesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/telephones', name: 'admin.telephones')]
class TelephonesController extends AbstractController
{
    public function __construct(
        private TelephonesRepository $repoTel
    ) {
    }

    #[Route('', name: '.index', methods: ['POST', 'GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Telephones/index.html.twig', [
            'telephones' => $this->repoTel->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['POST', 'GET'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $telephone = new Telephones();

        $form = $this->createForm(TelephoneForm::class, $telephone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repoTel->save($telephone);
            $this->addFlash('success', 'Article téléphone créé avec succès.');

            return $this->redirectToRoute('admin.telephones.index');
        }

        return $this->render('Backend/Telephones/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(?Telephones $telephone, Request $request): Response
    {
        if (!$telephone instanceof Telephones) {
            $this->addFlash('error', 'Téléphones non trouvé');

            return $this->redirectToRoute('admin.telephones.index');
        }
        $form = $this->createForm(TelephoneForm::class, $telephone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repoTel->save($telephone);
            $this->addFlash('success', 'Article téléphones créé avec succès');

            return $this->redirectToRoute('admin.telephones.index');
        }

        return $this->render('Backend/Telephones/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete', name: '.delete', methods: ['POST'])]
    public function delete(Request $request): RedirectResponse
    {
        $telephone = $this->repoTel->find($request->get('id', 0));

        if (!$telephone instanceof Telephones) {
            $this->addFlash('error', 'Téléphones non trouvé');

            return $this->redirectToRoute('admin.telephones.index');
        }

        if ($this->isCsrfTokenValid('delete' . $telephone->getId(), $request->get('token'))) {
            $this->repoTel->remove($telephone);
            $this->addFlash('success', 'Téléphone supprimé avec succès');

            return $this->redirectToRoute('admin.telephones.index');
        }

        $this->addFlash('error', 'Token invalide');

        return $this->redirectToRoute('admin.telephones.index');
    }

    #[Route('/switch/{id}', name: '.switch', methods: ['GET'])]
    public function switch(?Telephones $telephone): JsonResponse
    {
        if (!$telephone instanceof Telephones) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Téléphone non trouvé.',
            ], 404);
        }

        $telephone->setEnable(!$telephone->isEnable());

        $this->repoTel->save($telephone);

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Téléphone mis à jour avec succès.',
            'enable' => $telephone->isEnable(),
        ], 201);
    }
}
