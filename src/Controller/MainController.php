<?php

namespace App\Controller;

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
    #[Route('', 'app.homepage', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Home/home.html.twig', [
            'telephones' => $this->telephRepo->findAll()
        ]);
    }
}
