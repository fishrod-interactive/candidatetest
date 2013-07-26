<?php

namespace Julian\Bundle\CandTestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Guest
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Guest
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var integer
     *
     * @ORM\Column(name="wedding_id", type="integer")
     */
    private $weddingId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Guest
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Guest
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Guest
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    
        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Guest
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set weddingId
     *
     * @param integer $weddingId
     * @return Guest
     */
    public function setWeddingId($weddingId)
    {
        $this->weddingId = $weddingId;
    
        return $this;
    }

    /**
     * Get weddingId
     *
     * @return integer 
     */
    public function getWeddingId()
    {
        return $this->weddingId;
    }
}
