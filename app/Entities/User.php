<?php

namespace Entity;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email_idx", columns={"email"})})
 */
class User extends Authenticatable {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  protected $id;

  /**
   * @ORM\Column(type="string")
   */
  protected $name;

  /**
   * @ORM\Column(type="string")
   */
  protected $email;

  /**
   * @ORM\Column(type="string")
   */
  protected $password;

  /**
   * @ORM\Column(type="string", length=100, nullable=true)
   */
  protected $rememberToken;

  /**
   * @ORM\Column(type="datetime", nullable=true)
   */
  protected $created_at;

  /**
   * @ORM\Column(type="datetime", nullable=true)
   */
  protected $updated_at;

  /**
     * One User has Many Lists.
     * @ORM\OneToMany(targetEntity="ProductList", mappedBy="user")
     */
    private $lists;

  public function __construct($name, $email, $password) {
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->lists = new ArrayCollection();
  }

  public function getEmail() {
    return $this->email;
  }
}
