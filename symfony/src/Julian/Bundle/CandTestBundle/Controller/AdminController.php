<?php

namespace Julian\Bundle\CandTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Julian\Bundle\CandTestBundle\Entity\Wedding;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     *
     * Landing page for admin section
     *
     */
    public function indexAction()
    {
        return $this->render('JulianCandTestBundle:Admin:index.html.twig');
    }

    /**
     *
     * Action to handle the creation of new Weddings via a form
     *
     */
    public function newAction(Request $request)
    {
    	$wedding = new Wedding();

    	$form = $this->createFormBuilder($wedding)
    		->add('name', 'text')
    		->add('address', 'text')
    		->add('Create', 'submit')
    		->getForm();


    	$form->handleRequest($request);

    	if ($form->isValid()) {
            $wedding->setSlug($this->createSlug());
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($wedding);
            $em->flush();

    	 	return $this->redirect($this->generateUrl('task_success'));
    	}
    	
    	return $this->render('JulianCandTestBundle:Admin:form.html.twig', array(
    		'form' => $form->createView(),
    	));
    }

    public function formSuccessAction()
    {
        $this->get('session')->getFlashBag()->add(
            'notice',
            'Wedding created successfully!'
        );
    	return $this->redirect($this->generateUrl('admin'));
    }

    private function createSlug()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return time() . $randomString;
    }

    public function listAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('JulianCandTestBundle:Wedding');

        $weddings = $repository->findAll();

        return $this->render('JulianCandTestBundle:Admin:listWeddings.html.twig', array(
            'weddings' => $weddings
        ));
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $wedding = $em->getRepository('JulianCandTestBundle:Wedding')->find($id);

        $form = $this->createFormBuilder($wedding)
            ->add('name', 'text')
            ->add('address', 'text')
            ->add('Update', 'submit')
            ->getForm();


        $request = $this->getRequest();
        $form -> handleRequest($request);

        if ($form->isValid()) {
            $new_form = $this->get('request')->request->get('form');

            $wedding->setName($new_form['name']);
            $wedding->setAddress($new_form['address']);

            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($wedding);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Wedding created successfully!'
            );
        return $this->redirect($this->generateUrl('list_weddings'));
        }
       
        return $this->render('JulianCandTestBundle:Admin:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
