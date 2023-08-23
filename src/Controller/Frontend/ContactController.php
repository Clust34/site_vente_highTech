<?php

namespace App\Controller\Frontend;

use App\Entity\Message;
use App\Form\MessageForm;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{

    public function __construct(
        private MessageRepository $repoMes
    ) {
    }

    #[Route('/contact', name: 'app.contact', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $message = new Message();

        $form = $this->createForm(MessageForm::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repoMes->save($message);
            $this->addFlash('success', 'Votre message a été transmit avec succès.');

            return $this->redirectToRoute('app.homepage');
        }

        return $this->render('Frontend/Contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
