<?php
namespace App\Service;
use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

// Service pour manipuler le panier et le stocker en session
class PanierService {
    ////////////////////////////////////////////////////////////////////////////
    const PANIER_SESSION = 'panier';
    // Le nom de la variable de session du panier
    private $session;
    // Le service Session
    private $em;
    // Le service Boutique
    private $panier;
    // Tableau associatif idProduit => quantite
    // donc $this->panier[$i] = quantite du produit dont l'id = $i
    // constructeur du service
    public function __construct(SessionInterface $session, EntityManagerInterface $em){
        // Récupération des services session et de l'entity manager
        $this->em = $em;
        $this->session = $session;
        // Récupération du panier en session s'il existe, init. à vide sinon
        $this->panier = $session->get(self::PANIER_SESSION, []);
    }
    
    // getContenu renvoie le contenu du panier
    // tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
    public function getContenu(){
        $contenu = [];
        foreach ($this->panier as $idProduit => $quantite) {
            $contenu[] = ['produit' => $this->em->getRepository(Product::class)->find($idProduit), 'quantite' => $quantite];
        }
        return $contenu;
    }

    // getTotal renvoie le montant total du panier
    public function getTotal(){
        $total = 0;
        foreach ($this->panier as $idProduit => $quantite) {
            $total += $this->em->getRepository(Product::class)->find($idProduit)->getPrix() * $quantite;
        }
        return $total;
    }

    // getNbProduits renvoie le nombre de produits dans le panier
    public function getNbProduits(){
        $nbProduits = 0;
        foreach ($this->panier as $idProduit => $quantite) {
            $nbProduits += $quantite;
        }
        return $nbProduits;
    }

    // ajouterProduit ajoute au panier le produit $idProduit en quantite $quantite
    public function ajouterProduit(int $idProduit,int $quantite=1){
        if (isset($this->panier[$idProduit]) ) {
            $this->panier[$idProduit] += $quantite;
        } else {
            $this->panier[$idProduit] = $quantite;
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // enleverProduit enlève du panier le produit $idProduit en quantite $quantite
    public function enleverProduit(int $idProduit,int $quantite=1){
        if (isset($this->panier[$idProduit]) ) {
            if ($this->panier[$idProduit] <= 1) {
                unset($this->panier[$idProduit]);
            } else {
                $this->panier[$idProduit] -= $quantite;
            }
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // supprimerProduit supprime complètement le produit $idProduit du panier
    public function supprimerProduit(int$idProduit){
        if (isset($this->panier[$idProduit]) ) {
            unset($this->panier[$idProduit]);
        }
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }

    // vider vide complètement le panier
    public function vider(){
        $this->panier = [];
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }
}