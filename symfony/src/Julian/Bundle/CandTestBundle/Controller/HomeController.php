<?php

namespace Julian\Bundle\CandTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Julian\Bundle\CandTestBundle\Entity\Wedding;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('JulianCandTestBundle:Home:index.html.twig');
    }
}
