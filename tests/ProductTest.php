<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Entity\Product;
use Entity\User;
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

    public function testSearchProduct() {
        $this->user = new User('test', sprintf('test-%s@mail.com', microtime(true)), '123456');
        EntityManager::persist($this->user);
        EntityManager::flush();
        $this->product = new Product(sprintf('ABC-%s', microtime(true)), 'TEST PRODUCT');
        $this->productCustom = new Product(sprintf('ABCD-%s', microtime(true)), 'TEST PRODUCT2', $this->user);
        EntityManager::persist($this->product);
        EntityManager::persist($this->productCustom);
        EntityManager::flush();
        $rep = EntityManager::getRepository(Product::class);
        $this->assertEquals($rep->findByBarcode($this->product->getBarcode())[0]->getId(), $this->product->getId());
        $this->assertEmpty($rep->findByBarcode($this->productCustom->getBarcode()));
        $this->assertEquals($rep->findByBarcode($this->productCustom->getBarcode(), $this->user)[0]->getId(), $this->productCustom->getId());
        $this->assertEquals($rep->findOneByBarcode($this->product->getBarcode())->getId(), $this->product->getId());
        $this->assertEmpty($rep->findOneByBarcode($this->productCustom->getBarcode()));
        $this->assertEquals($rep->findOneByBarcode($this->productCustom->getBarcode(), $this->user)->getId(), $this->productCustom->getId());
        EntityManager::remove($this->productCustom);
        EntityManager::remove($this->product);
        EntityManager::remove($this->user);
        EntityManager::flush();
    }

}
