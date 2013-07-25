<?php

namespace Julian\Bundle\CandTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Julian\Bundle\CandTestBundle\Entity\Wedding;
use Symfony\Component\HttpFoundation\Request;

class GuestBookController extends Controller
{
    public function indexAction()
    {
        return $this->render('JulianCandTestBundle:GuestBook:index.html.twig');
    }

}
