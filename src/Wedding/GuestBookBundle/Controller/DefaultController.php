<?php

namespace Wedding\GuestBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction()
    {
        $result = array();
        $result['page_title'] = 'Home';
        $result['name'] = 'dave';
        $result['navigation'] = array();
        $result['navigation'][] = array('url'=>'/admin','label'=> 'Log in');

        return $result;
    }
}
