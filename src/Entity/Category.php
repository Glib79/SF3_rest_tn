<?php // src/Entity/Category.php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 * @ORM\HasLifecycleCallbacks
 */
class Category {
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
}
