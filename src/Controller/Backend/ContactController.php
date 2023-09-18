<?php

namespace App\Controller\Backend;

use App\Entity\Message;
use App\Entity\Telephones;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    public function __construct(
        private MessageRepository $repoMes
    ) {
    }

    #[Route('admin/contact', name: 'admin.contact')]
    public function index(): Response
    {


        return $this->render('Backend/Contact/index.html.twig', [
            'messages' => $this->repoMes->findAllOrder(),
        ]);
    }

    #[Route('admin/contact/voir/{id}', name: '.admin.contact.voir', methods: ['GET'])]
    public function show(?Message $message): Response
    {
        if (!$message instanceof Message) {
            $this->addFlash('error', 'Aucun message trouvé.');

            return $this->redirectToRoute('admin.contact');
        }

        return $this->render('Backend/Contact/show.html.twig', [
            'message' => $message,
        ]);
    }
}
