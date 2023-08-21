<?php

namespace App\Controller\Frontend;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/compte')]
class UserController extends AbstractController
{
    public function __construct(
        private Security $security,
        private UserRepository $repo
    ) {
    }

    #[Route('', name: 'compte')]
    public function show(): Response
    {
        $user = $this->security->getUser();

        return $this->render('Frontend/User/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/edit-account', name: 'front.user.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepo): Response
    {
        $user = $this->security->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepo->save($user);

            return $this->redirectToRoute('compte', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Backend/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
