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
        $telephones = $telephRepo->findLatest(3);
        $tablette = $repoTab->findLatest(3);
        $ordinateur = $repoOrdi->findLatest(3);

        return $this->render('Home/home.html.twig', [
            'telephones' => $telephones,
            'ordinateurs' => $ordinateur,
            'tablettes' => $tablette
        ]);
    }
}
