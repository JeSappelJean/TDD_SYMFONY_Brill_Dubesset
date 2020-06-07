<?php

namespace App\Controller;
use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoutiqueController extends AbstractController {
    
    public function index() {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('boutique.html.twig', ["categories" => $categories]);
    }

    public function rayon(int $idCategory) {
        $produits = $this->getDoctrine()->getRepository(Product::class)->findByCategory($idCategory);
        $category = $this->getDoctrine()->getRepository(Category::class)->find($idCategory);
        return $this->render('rayon.html.twig', ["produits" => $produits,"category" => $category]);
    }
}