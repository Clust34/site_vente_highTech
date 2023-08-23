<?php

namespace App\Controller\Frontend;


use App\Entity\Telephones;
use App\Repository\TelephonesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/telephone')]
class TelephoneController extends AbstractController
{
    #[Route('/details/{slug}', name: 'telephone.show')]
    public function index(?Telephones $telephone, TelephonesRepository $repoTel): Response
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
