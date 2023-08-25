<?php

namespace App\Controller\Frontend;

use App\Data\SearchData;
use App\Entity\Ordinateurs;
use App\Form\SearchMarqueForm;
use App\Repository\OrdinateursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ordinateur')]
class OrdinateurController extends AbstractController
{
    public function __construct(
        private OrdinateursRepository $repoOrdi
    ) {
    }
    #[Route('', name: '.ordinateur', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $data = new SearchData;

        $form = $this->createForm(SearchMarqueForm::class, $data);
        $form->handleRequest($request);

        $ordinateur = $this->repoOrdi->findSearchData($data);

        return $this->render('Frontend/Ordinateurs/indexOrdi.html.twig', [
            'ordinateurs' => $ordinateur,
            'form' => $form
        ]);
    }

    #[Route('/details/{slug}', name: 'ordinateur.show')]
    public function detail(?Ordinateurs $ordinateur): Response
    {
        if (!$ordinateur instanceof Ordinateurs) {
            $this->addFlash('error', 'Aucun produit trouvé.');

            return $this->redirectToRoute('app.homepage');
        }

        return $this->render('Frontend/Ordinateurs/index.html.twig', [
            'ordinateur' => $ordinateur,
        ]);
    }
}
