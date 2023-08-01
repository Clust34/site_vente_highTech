<?php

namespace App\Controller\Backend;

use App\Entity\Telephones;
use App\Form\TelephoneForm;
use App\Repository\TelephonesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
