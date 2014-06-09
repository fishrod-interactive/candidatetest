<?php

namespace Wedding\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

use Wedding\AdminBundle\Form\Type\RegistrationType;
use Wedding\AdminBundle\Form\Model\Registration;
use Wedding\AdminBundle\Entity\User;

use Wedding\GuestBookBundle\Entity\Wedding;
use Wedding\GuestBookBundle\Form\Type\WeddingType;


class AdminController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function adminAction()
    {
        $sc = $this->get('security.context');
        $is_admin = $sc->isGranted('ROLE_SUPER_ADMIN');
        $result = array();
        $result['page_title'] = 'Admin';
        $result['navigation'] = array();
        
        if($is_admin) {
            $result['navigation'][] = array('url'=>$this->generateUrl('adduser'),'label'=> 'Add user');
        }
        $result['navigation'][] = array('url'=>$this->generateUrl('logout'),'label'=> 'Logout');
        
        $wedding = new Wedding();
        $form = $this->createForm(new WeddingType(), $wedding , array(
            'action' => $this->generateUrl('addwedding'),
            'method' => 'POST',
        ));
        $result['form'] = $form->createView();
        return $result;
    }
    
    public function addweddingAction(Request $request)
    {
        $sc = $this->get('security.context');
        $is_admin = $sc->isGranted('ROLE_SUPER_ADMIN');
        $em = $this->getDoctrine()->getManager();
        $wedding = new Wedding();
        
        $form = $this->createForm(new WeddingType(),$wedding);

        $form->handleRequest($request);
        $result = array();
        $result['page_title'] = 'Add Wedding';
        $result['navigation'] = array();
        $result['navigation'][] = array('url'=>$this->generateUrl('admin'),'label'=> 'Admin panel');
        if($is_admin) {
            $result['navigation'][] = array('url'=>$this->generateUrl('adduser'),'label'=> 'Add user');
        }
        $result['navigation'][] = array('url'=>$this->generateUrl('logout'),'label'=> 'Logout');
        $result['url'] = '';

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wedding);
            $em->flush();
            $result['url'] = $this->generateUrl(
            'wedding',array('slug' => $wedding->getSlug()), true);
            
            return $this->render(
                'WeddingAdminBundle:Admin:addwedding.html.twig',
                $result
            );
        }

        return $this->render(
            'WeddingAdminBundle:Admin:admin.html.twig',
            $result
        );
    }
    public function adduserAction()
    {
        if (!$this->get('security.context')->isGranted("ROLE_SUPER_ADMIN"))
        {
            throw new AccessDeniedException();
        }
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('adduser_create'),
        ));
        
        $result = array();
        $result['page_title'] = 'Admin';
        $result['navigation'] = array();
        $result['navigation'][] = array('url'=>$this->generateUrl('admin'),'label'=> 'Admin panel');
        $result['navigation'][] = array('url'=>$this->generateUrl('logout'),'label'=> 'Logout');
        $result['form'] = $form->createView();

        return $this->render(
            'WeddingAdminBundle:Admin:adduser.html.twig',
            $result
        );
    }
    
    public function adduser_createAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted("ROLE_SUPER_ADMIN"))
        {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();
            $factory = $this->get('security.encoder_factory');
            $user = new User();
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($registration->getUser()->getPassword(), $user->getSalt());

            $registration->getUser()->setPassword($password);

            $em->persist($registration->getUser());
            $em->flush();


        }

        return $this->render(
            'WeddingAdminBundle:Admin:adduser.html.twig',
            array('form' => $form->createView())
        );
    }
}