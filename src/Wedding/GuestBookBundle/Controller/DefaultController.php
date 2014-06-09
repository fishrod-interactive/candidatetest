<?php

namespace Wedding\GuestBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Wedding\GuestBookBundle\Entity\Guest;
use Wedding\GuestBookBundle\Form\Type\GuestType;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $result = array();
        $result['page_title'] = 'Wedding Guest Book';
        $result['navigation'] = array();
        $result['navigation'][] = array('url'=>$this->generateUrl('admin'),'label'=> 'Log in');

        return $result;
    }
    /**
     * @Route("/wedding/{slug}", name="wedding")
     * @Template()
     */
    public function weddingAction($slug)
    {
        $guest = new Guest();
        $form = $this->createForm(new GuestType(), $guest , array(
            'action' => $this->generateUrl('addentry',array('slug' => $slug)),
            'method' => 'POST',
        ));
        $result = array();
        $result['page_title'] = 'Home';
        $result['navigation'] = array();
        $result['navigation'][] = array('url'=>$this->generateUrl('admin'),'label'=> 'Log in');
        $result['form'] = $form->createView();
        return $this->render(
            'WeddingGuestBookBundle:Default:wedding.html.twig',
            $result
        );
    }
    /**
     * @Route("/addentry/{slug}", name="addentry")
     * @Template()
     */
    public function addentryAction($slug, Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT w
            FROM WeddingGuestBookBundle:Wedding w
            WHERE w.slug = :slug'
        )->setParameter('slug', $slug);

        $wedding_entry = $query->getSingleResult();
        $wedding_id = $wedding_entry->getId();
        $guest = new Guest();
        
        $form = $this->createForm(new GuestType(), $guest);
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $guest_data = $form->getData();
            $guest_data->setCreated();
            $guest_data->setWeddingId($wedding_id);
            $someNewFilename = uniqid();
            $file = $form['photo']->getData();
            $dir = __DIR__.'/../../../../web/uploads/images';
            
            $extension = $file->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'bin';
            }
            $file->move($dir, $someNewFilename.'.'.$extension);
            $guest_data->setPhoto($someNewFilename.'.'.$extension);
            $em->persist($guest_data);
            $em->flush();


        }
        $result = array();
        $result['page_title'] = 'Home';
        $result['navigation'] = array();
        $result['navigation'][] = array('url'=>$this->generateUrl('admin'),'label'=> 'Log in');
        
        return $this->render(
            'WeddingGuestBookBundle:Default:addentry.html.twig',
            $result
        );
    }
    
}
