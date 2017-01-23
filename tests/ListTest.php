<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Entity\Product;
use Entity\ProductList;

class ListTest extends TestCase
{
      private $product;
      private $list;

     public function setUp() {
      parent::setUp();
      $this->product = new Product('ABC', 'TEST PRODUCT');
      EntityManager::persist($this->product);
      EntityManager::flush();
      $this->list = new ProductList();
      EntityManager::persist($this->list);
      EntityManager::flush();

    }

    public function tearDown() {
      parent::tearDown();
      EntityManager::remove($this->list);
      EntityManager::flush();
      EntityManager::remove($this->product);
      EntityManager::flush();
    }

    /**
     * Check add product in list
     *
     * @return void
     */
    public function testIsInList()
    {
        $this->list->addProduct($this->product);
        $this->assertContains($this->product, $this->list->getProducts());
    }

    public function testApiInsertion()
    {
      $response = $this->call('POST', '/list/add',
        [
          'list' => $this->list->getId(),
          'product' => $this->product->getBarcode()
        ]);
        $this->assertEquals($response->status(), 200);
        $list = EntityManager::getRepository(ProductList::class)->findOneBy(['id' => $this->list->getId()], ['id' => 'desc']);
        $this->assertContains($this->product, $list->getProducts());
    }

    public function testNewList() {
        $list = EntityManager::getRepository(ProductList::class)->findAll();
        $oldCount = count($list);
        $response = $this->call('POST', '/list/', []);
        $this->assertEquals($response->status(), 200);
        $list = EntityManager::getRepository(ProductList::class)->findAll();
        $this->assertCount($oldCount+1, $list);
    }
    
}
