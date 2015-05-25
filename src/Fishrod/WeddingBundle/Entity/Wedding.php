<?php

namespace Fishrod\WeddingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Fishrod\GuestBundle\Entity\Guest;

/**
 * Wedding
 *
 * Table name convention: bundle_entity
 * @ORM\Table(name="wedding_wedding")
 * @ORM\Entity(repositoryClass="Fishrod\WeddingBundle\Entity\WeddingRepository")
 */
class Wedding
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
     * @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="Fishrod\GuestBundle\Entity\Guest", mappedBy="wedding")
     */
    protected $guests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->guests = new ArrayCollection();
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
     * @return Wedding
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
     * Set address
     *
     * @param string $address
     * @return Wedding
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Wedding
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Remove guest
     *
     * @param Guest $guest
     * @return Wedding
     */
    public function removeGuest(Guest $guest)
    {
        $this->guests->removeElement($guest);

        return $this;
    }

    /**
     * Get guests
     *
     * @return ArrayCollection
     */
    public function getGuests()
    {
        return $this->guests;
    }

    /**
     * Add guest
     *
     * @param Guest $guest
     * @return Wedding
     */
    public function addGuest(Guest $guest)
    {
        $this->guests[] = $guest;

        return $this;
    }
}
