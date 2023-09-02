<?php

namespace App\Controller\Frontend;


use App\Data\SearchData;
use App\Entity\Tablettes;
use App\Form\SearchMarqueFormTab;
use App\Repository\TablettesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tablette')]
class TabletteController extends AbstractController
{
    public function __construct(
        private TablettesRepository $repoTab
    ) {
    }
    #[Route('', name: '.tablette', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $data = new SearchData;

        $form = $this->createForm(SearchMarqueFormTab::class, $data);
        $form->handleRequest($request);

        $tablettes = $this->repoTab->findSearchData($data);

        return $this->render('Frontend/Tablettes/indexTab.html.twig', [
            'tablettes' => $tablettes,
            'form' => $form
        ]);
    }

    #[Route('/details/{slug}', name: 'tablette.show')]
    public function detail(?Tablettes $tablette): Response
    {
        if (!$tablette instanceof Tablettes) {
            $this->addFlash('error', 'Aucun produit trouvé.');

            return $this->redirectToRoute('app.homepage');
        }

        return $this->render('Frontend/Tablettes/index.html.twig', [
            'tablette' => $tablette,
        ]);
    }
}
