<?php 

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Category;
use App\Entity\Product;

class CategoryTest extends TestCase {

    protected $category;
    protected $product;

    public function setUp() : void {
        $this->category = new Category();
        $this->product = new Product();
    }

    public function testCategory() {
        $this->assertInstanceOf(Category::class, $this->category);
        $this->assertNull($this->category->getId());
    }

    public function testCategoryLibelle() {
        $this->category->setLibelle("Cyclisme");
        $this->assertEquals("Cyclisme", $this->category->getLibelle());
    }

    public function testCategoryVisuel() {
        $this->category->setVisuel("test.jpg");
        $this->assertEquals("test.jpg", $this->category->getVisuel());
    }

    public function testCategoryTexte() {
        $this->category->setTexte("Ceci est un texte pour cyclisme");
        $this->assertEquals("Ceci est un texte pour cyclisme", $this->category->getTexte());
    }
    
    public function testCategoryProducts() {
        $this->category->addProduct($this->product);
        $this->assertContains($this->product, $this->category->getProducts());
        $this->category->removeProduct($this->product);
        $this->assertNotContains($this->product, $this->category->getProducts());
    }

}