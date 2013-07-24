<?php

namespace Julian\Bundle\CandTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JulianCandTestBundle:Default:index.html.twig', array('name' => $name));
    }
}
