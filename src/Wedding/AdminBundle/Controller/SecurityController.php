<?php
namespace Wedding\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;



class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);
        
        $result = array();
        $result['page_title'] = 'Home';
        $result['name'] = 'dave';
        $result['last_username'] = $lastUsername;
        $result['error'] = $error;
        $result['navigation'] = array();
        $result['navigation'][] = array('url'=>$this->generateUrl('admin'),'label'=> 'Log in');

        return $this->render(
            'WeddingAdminBundle:Security:login.html.twig',
            $result
        );
    }
    
    
}

