<?php

namespace Fishrod\GuestBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Fishrod\WeddingBundle\Entity\Wedding;

/**
 * Guest
 * Anonymous user
 *
 * Table name convention: bundle_entity
 * @ORM\Table(name="guest_guest")
 * @ORM\Entity(repositoryClass="Fishrod\GuestBundle\Entity\GuestRepository")
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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    protected $message;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Fishrod\WeddingBundle\Entity\Wedding", inversedBy="guests")
     * @ORM\JoinColumn(name="wedding_id", referencedColumnName="id")
     */
    protected $wedding;

    /**
     * @ORM\ManyToOne(targetEntity="Fishrod\MediaBundle\Entity\Photo")
     * @ORM\JoinColumn(name="photo", referencedColumnName="id", nullable=true)
     */
    protected $photo;


    public function __construct()
    {
        $this->created = new DateTime();
    }

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
     * @param DateTime $created
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
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set wedding
     *
     * @param Wedding $wedding
     * @return Guest
     */
    public function setWedding(Wedding $wedding)
    {
        $this->wedding = $wedding;

        return $this;
    }

    /**
     * Get wedding
     *
     * @return Wedding
     */
    public function getWedding()
    {
        return $this->wedding;
    }
}
