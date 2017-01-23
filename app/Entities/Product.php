<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="product")
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
    * @param $firstname
    * @param $lastname
    */
    public function __construct($barcode, $name)
    {
        $this->barcode = $barcode;
        $this->name  = $name;
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
