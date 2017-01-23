<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Entity\Product;
use Entity\ProductList;

class ProductTest extends TestCase
{
    public function testCreateProduct() {
      $response = $this->call('POST', '/product/',
        [
          'barcode' => 'TESTBARCODE',
          'name' => 'TEST PRODUCT'
        ]
      );
      $this->assertEquals($response->status(), 200);
      $prod = EntityManager::getRepository(Product::class)->findOneBy(['barcode' => 'TESTBARCODE']);
      $this->assertNotNull($prod);
      EntityManager::remove($prod);
      EntityManager::flush();
    }

    public function testCreateAddToList() {
      $list = new ProductList();
      EntityManager::persist($list);
      EntityManager::flush();
      $response = $this->call('POST', '/product/',
        [
          'barcode' => 'TESTBARCODE',
          'name' => 'TEST PRODUCT',
          'includeList' => 1,
          'list' => $list->getId()
        ]
      );
      $this->assertEquals($response->status(), 200);
      $prod = EntityManager::getRepository(Product::class)->findOneBy(['barcode' => 'TESTBARCODE'], ['id' => 'desc']);
      $this->assertNotNull($prod);
      $this->assertContains($prod, $list->getProducts());
      EntityManager::remove($list);
      EntityManager::flush();
      EntityManager::remove($prod);
      EntityManager::flush();

    }
}
