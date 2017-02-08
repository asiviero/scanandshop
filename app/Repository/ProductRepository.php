<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\Product;

class ProductRepository extends EntityRepository
{

  public function findByBarcode($barcode, $user = null)
  {
    $q = app('em')
    ->createQuery("
      select p from Entity\Product p where p.barcode = :barcode
       and (p.user is null or p.user = :user) order by p.id desc
      ")
      ->setParameters([
          'barcode' => $barcode,
          'user' => $user
        ]);
      return $q->getResult();
  }

  public function findOneByBarcode($barcode, $user = null)
  {
    return $this->findByBarcode($barcode, $user) ? $this->findByBarcode($barcode, $user)[0] : null;
  }

}
