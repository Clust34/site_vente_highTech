<?php

namespace App\Controller\Frontend;

use App\Data\SearchData;
use App\Entity\Telephones;
use App\Form\SearchMarqueForm;
use App\Repository\TelephonesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/telephone')]
class TelephoneController extends AbstractController
{
    public function __construct(
        private TelephonesRepository $repoTel
    ) {
    }

    #[Route('', name: '.telephone', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $data = new SearchData;

        $form = $this->createForm(SearchMarqueForm::class, $data);
        $form->handleRequest($request);

        $telephones = $this->repoTel->findSearchData($data);

        return $this->render('Frontend/Telephones/indexTel.html.twig', [
            'telephones' => $telephones,
            'form' => $form
        ]);
    }

    #[Route('/details/{slug}', name: 'telephone.show')]
    public function show(?Telephones $telephone, TelephonesRepository $repoTel): Response| RedirectResponse
    {
        if (!$telephone instanceof Telephones) {
            $this->addFlash('error', 'Aucun produit trouvé.');

            return $this->redirectToRoute('app.homepage');
        }

        return $this->render('Frontend/Telephones/index.html.twig', [
            'telephone' => $telephone,
        ]);
    }
}
