<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="list")
 */
class ProductList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="list_product",
     *      joinColumns={@ORM\JoinColumn(name="list_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    protected $products;

    /**
     * Many Lists have One User.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="lists")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function __construct($user = null)
    {
        $this->products = new ArrayCollection();
        $this->user = $user;
    }

    public function getId() {
      return $this->id;
    }
    public function addProduct($product) {
      if(!$this->products->contains($product)) {
        $this->products->add($product);
      }
    }

    public function getProducts() {
      return $this->products;
    }
}
