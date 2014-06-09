<?php
namespace Wedding\AdminBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Wedding\AdminBundle\Entity\User;

class Registration
{
    /**
     * @Assert\Type(type="Wedding\AdminBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;


    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

  
}
