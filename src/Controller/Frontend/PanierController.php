<?php

namespace App\Controller\Frontend;

use App\Entity\Ordinateurs;
use App\Entity\Tablettes;
use App\Entity\Telephones;
use App\Repository\OrdinateursRepository;
use App\Repository\TablettesRepository;
use App\Repository\TelephonesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: '.panier')]
class PanierController extends AbstractController
{

    #[Route('/', name: '.index')]
    public function index(SessionInterface $session, 
    TelephonesRepository $telephonesRepository, TablettesRepository $tabletteRepository, OrdinateursRepository $ordinateursRepository)
    {
        $panier = $session->get('panier', []);
        // On initialise des variables
        $data = [];
        $dataTab = [];
        $dataOrdi = [];
        $total = 0;

        // Avec id
        // foreach($panier as $id => $quantity){
        //     $telephone = $telephonesRepository->find($id);
        //     dd($telephone);
        //     $data[] = [
        //         'telephone' => $telephone,
        //         'quantity' => $quantity
        //     ];
        //     $total += $telephone->getPrix() * $quantity;      
        //  }

        // Avec slug   
        foreach($panier as $slug => $quantity){  
            if($telephonesRepository->findOneBySlug($slug)){
                $telephone = $telephonesRepository->findOneBySlug($slug);
                $data[] = [
                    'telephone' => $telephone,
                    'quantity' => $quantity
                ];
                $total += $telephone->getPrix() * $quantity;
            }    
            
            if($tabletteRepository->findOneBySlug($slug)){
                $tablette = $tabletteRepository->findOneBySlug($slug);
                $dataTab[] = [
                    'tablette' => $tablette,
                    'quantity' => $quantity
                ];
                $total += $tablette->getPrix() * $quantity;
            }

            if($ordinateursRepository->findOneBySlug($slug)){
                $ordinateur = $ordinateursRepository->findOneBySlug($slug);
                $dataOrdi[] = [
                    'ordinateur' => $ordinateur,
                    'quantity' => $quantity
                ];
                $total += $ordinateur->getPrix() * $quantity;
            }
        }

        return $this->render('Frontend/Panier/panier.html.twig', 
        //compact('data', 'total', 'dataTab', 'dataOrdi')
        [
            'data' => $data,
            'total' => $total,
            'dataTab' => $dataTab,
            'dataOrdi' => $dataOrdi
        ]
    );
    }

    #[Route('/ajout/{id}', name:'.ajout')]
    public function ajoutPanier(?Telephones $telephones, ?Tablettes $tablettes, ?Ordinateurs $ordinateurs, SessionInterface $session): Response
    {

        // Avec id
        // if($telephones instanceof Telephones){
        //     // On récupère l'id du produit
        // $idTel = $telephones->getId();
        // // On récupère le panier existant
        // $panier = $session->get('panier', []);
        // // On ajoute le produit dans le panier si il n'ya est pas encore
        // // Sinon on incréménte sa quantité
        // if(empty($panier[$idTel])){
        //     $panier[$idTel] = 1;
        // }else{
        //     $panier[$idTel]++;
        // }
        // }

        // Avec slug
        if($telephones instanceof Telephones){
            $slugTel = $telephones->getSlug();
            $panier = $session->get('panier', []);

            if(empty($panier[$slugTel])){
                $panier[$slugTel] = 1;
            }else{
                $panier[$slugTel]++;
        }
        }

        if($tablettes instanceof Tablettes){
            $slugTab = $tablettes->getSlug();
            $panier = $session->get('panier', []);

            if(empty($panier[$slugTab])){
                $panier[$slugTab] = 1;
            }else{
                $panier[$slugTab]++;
            }
        }

        if($ordinateurs instanceof Ordinateurs){
            $slugOrdi = $ordinateurs->getSlug();
            $panier = $session->get('panier', []);

            if(empty($panier[$slugOrdi])){
                $panier[$slugOrdi] = 1;
            }else{
                $panier[$slugOrdi]++;
            }
        }
        
        $session->set('panier', $panier);

        return $this->redirectToRoute('.panier.index');
    }

    #[Route('/remove/{id}', name:'.remove')]
    public function removePanier(?Telephones $telephones, ?Tablettes $tablettes, ?Ordinateurs $ordinateurs, SessionInterface $session): Response
    {

        // Avec Id
        // // On récupère l'id du produit
        // $idTel = $telephones->getId();
        // // On récupère le panier existant
        // $panier = $session->get('panier', []);
        // // On retirer le produit du panier si il n'ya qu'un exemplaire
        // // Sinon on décréménte sa quantité
        // if(!empty($panier[$idTel])){
        //    if($panier[$idTel] > 1){
        //         $panier[$idTel]--;
        //    }else{
        //         unset($panier[$idTel]);
        //    }
        // }

        // Avec Slug
        if($telephones instanceof Telephones){
            $slugTel = $telephones->getSlug();
            $panier = $session->get('panier', []);
            if(!empty($panier[$slugTel])){
                if($panier[$slugTel] > 1){
                    $panier[$slugTel]--;
                }else{
                    unset($panier[$slugTel]);
                }
            }
        }

        if($tablettes instanceof Tablettes){
            $slugTab = $tablettes->getSlug();
            $panier = $session->get('panier', []);
            if(!empty($panier[$slugTab])){
                if($panier[$slugTab] > 1){
                    $panier[$slugTab]--;
                }else{
                    unset($panier[$slugTab]);
                }
            }
        }

        if($ordinateurs instanceof Ordinateurs){
            $slugOrdi = $ordinateurs->getSlug();
            $panier = $session->get('panier', []);
            if(!empty($panier[$slugOrdi])){
                if($panier[$slugOrdi] > 1){
                    $panier[$slugOrdi]--;
                }else{
                    unset($panier[$slugOrdi]);
                }
            }
        }

        $session->set('panier', $panier);

        // On redirige vers la page du panier
        return $this->redirectToRoute('.panier.index');
    }

    #[Route('/delete/{id}', name:'.delete')]
    public function suprPanier(?Telephones $telephones, ?Tablettes $tablettes, ?Ordinateurs $ordinateurs, SessionInterface $session): Response
    {

        // Avec Id
        // // On récupère l'id du produit
        // $idTel = $telephones->getId();
        // // On récupère le panier existant
        // $panier = $session->get('panier', []);
        // if(!empty($panier[$idTel])){
        //         unset($panier[$idTel]);
        // }

        // Avec Slug
        if($telephones instanceof Telephones){
            $slugTel = $telephones->getSlug();
            $panier = $session->get('panier', []);
            if(!empty($panier[$slugTel])){
                unset($panier[$slugTel]);
            }
        }

        if($tablettes instanceof Tablettes){
            $slugTab = $tablettes->getSlug();
            $panier = $session->get('panier', []);
            if(!empty($panier[$slugTab])){
                unset($panier[$slugTab]);
            }
        }

        if($ordinateurs instanceof Ordinateurs){
            $slugOrdi = $ordinateurs->getSlug();
            $panier = $session->get('panier', []);
            if(!empty($panier[$slugOrdi])){
                unset($panier[$slugOrdi]);
            }
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('.panier.index');
    }

    #[Route('/empty', name:'.empty')]
    public function Empty(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('.panier.index');
    }
}
