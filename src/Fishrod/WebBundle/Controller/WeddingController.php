<?php

namespace Fishrod\WebBundle\Controller;

use Fishrod\WeddingBundle\Entity\Wedding;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/wedding")
 * @Template()
 */
class WeddingController extends Controller
{
    /**
     * @Route("/view/{slug}")
     * @param Wedding $wedding
     * @return array
     */
    public function viewAction(Wedding $wedding)
    {
        return $this->render(
            'FishrodWebBundle:Wedding:view.html.twig',
            ['wedding' => $wedding]
        );
    }
}