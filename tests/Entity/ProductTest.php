<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;
use App\Entity\Category;

class ProductTest extends TestCase
{
    protected $product;
    protected $category;

    public function setUp() : void
    {
        $this->product = new Product();
        $this->category = new Category();
    }

    public function testProduct()
    {
        $this->assertInstanceOf(Product::class, $this->product);
        $this->assertNull($this->product->getId());
    }

    public function testProductCategory()
    {
        $this->product->setCategory($this->category);
        $this->assertEquals($this->category, $this->product->getCategory());
    }

    public function testProductLibelle() {
        $this->product->setLibelle("Velo");
        $this->assertEquals("Velo", $this->product->getLibelle());
    }

    public function testProductTexte() {
        $this->product->setTexte("Ceci est un velo");
        $this->assertEquals("Ceci est un velo", $this->product->getTexte());
    }

    public function testProductVisuel() {
        $this->product->setVisuel("test.jpg");
        $this->assertEquals("test.jpg", $this->product->getVisuel());
    }

    public function testProductPrix() {
        $this->product->setPrix(200.5);
        $this->assertEquals(200.5, $this->product->getPrix());
    }


}