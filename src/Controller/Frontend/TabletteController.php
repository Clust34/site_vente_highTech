<?php

namespace App\Controller\Frontend;


use App\Entity\Tablettes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tablette')]
class TabletteController extends AbstractController
{
    #[Route('/details/{slug}', name: 'tablette.show')]
    public function index(?Tablettes $tablette): Response
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
