<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $barcode;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
    * @ORM\ManyToOne(targetEntity="User")
    */
    protected $user;

    /**
    * @param $firstname
    * @param $lastname
    * @param $user
    */
    public function __construct($barcode, $name, $user = null)
    {
        $this->barcode = $barcode;
        $this->name  = $name;
        $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBarcode()
    {
        return $this->barcode;
    }

}
