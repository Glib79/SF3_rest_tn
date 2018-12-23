<?php // src/Entity/Product.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks
 */
class Product {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    public $name;
    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    /**
     * @ORM\Column(type="string", length=5)
     */
    public $sku;
    /**
     * @ORM\Column(type="float")
     */
    public $price;
    /**
     * @ORM\Column(type="integer")
     */
    public $quantity;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
    /**
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $modified_at;
    
    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime("now");
        $this->modified_at = new \DateTime("now");
    }
    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->modified_at = new \DateTime("now");
    }

    // Getters and setters
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getCategory()
    {
        return $this->category->getName();
    }
    public function setCategory($category)
    {
	if(!$category instanceof Category) {
	    $this->category = null;
	}else{	
	    $this->category = $category;
	}
    }
    public function getSku()
    {
        return $this->sku;
    }
    public function setSku($sku)
    {
        $this->sku = $sku;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

}
