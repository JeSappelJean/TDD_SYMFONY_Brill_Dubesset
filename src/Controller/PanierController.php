<?php

namespace App\Controller;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController {

    private $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }
    
    public function index() {
        $panier = $this->panierService->getContenu();
        $total = $this->panierService->getTotal();
        return $this->render('panier/index.html.twig', ['panier' => $panier,'total' => $total]);
    }

    public function ajouter($idProduit, $quantite) {
        $this->panierService->ajouterProduit($idProduit, $quantite);
        return $this->redirectToRoute('panier_index');
    }

    public function enlever($idProduit, $quantite) {
        $this->panierService->enleverProduit($idProduit, $quantite);
        return $this->redirectToRoute('panier_index');
    }

    public function supprimer($idProduit) {
        $this->panierService->supprimerProduit($idProduit);
        return $this->redirectToRoute('panier_index');
    }

    public function vider() {
        $this->panierService->vider();
        return $this->redirectToRoute('panier_index');
    }
}