<?php

namespace App\Controller;

use App\Repository\OrdinateursRepository;
use App\Repository\TablettesRepository;
use App\Repository\TelephonesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public function __construct(
        private TelephonesRepository $telephRepo
    ) {
    }
    #[Route('', name: 'app.homepage', methods: ['GET'])]
    public function index(TelephonesRepository $telephRepo, OrdinateursRepository $repoOrdi, TablettesRepository $repoTab): Response
    {
        $telephones = $telephRepo->findLatest(6);
        $tablette = $repoTab->findLatest(6);
        $ordinateur = $repoOrdi->findLatest(6);

        return $this->render('Home/home.html.twig', [
            'telephones' => $telephones,
            'ordinateurs' => $ordinateur,
            'tablettes' => $tablette
        ]);
    }

    #[Route('/mentions/legales', name: 'mentions.legales')]
    public function mention(): Response
    {
        return $this->render('Footer/mentionsLegales.html.twig');
    }

    #[Route('/cgv', name: '.cgv')]
    public function cgv(): Response
    {
        return $this->render('Footer/cgv.html.twig');
    }

    #[Route('/donneesPerso', name: '.donneesPerso')]
    public function donneesPerso(): Response
    {
        return $this->render('Footer/donneesPerso.html.twig');
    }

    #[Route('/cookies', name: '.cookies')]
    public function cookies(): Response
    {
        return $this->render('Footer/cookies.html.twig');
    }
}
