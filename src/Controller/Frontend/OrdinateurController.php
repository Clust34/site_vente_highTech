<?php

namespace App\Controller\Frontend;

use App\Entity\Ordinateurs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ordinateur')]
class OrdinateurController extends AbstractController
{
    #[Route('/details/{slug}', name: 'ordinateur.show')]
    public function index(?Ordinateurs $ordinateur): Response
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
