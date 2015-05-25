<?php

namespace Fishrod\WebBundle\Controller;

use Fishrod\WeddingBundle\Entity\Wedding;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/guest")
 * @Template()
 */
class GuestController extends Controller
{
    /**
     * @Route("/create")
     * @return array
     */
    public function createGuestEntryAction()
    {
        return $this->render(
            'FishrodWebBundle:Guest:create.html.twig'
        );
    }
}