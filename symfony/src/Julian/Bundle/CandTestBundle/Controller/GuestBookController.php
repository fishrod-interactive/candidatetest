<?php

namespace Julian\Bundle\CandTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Julian\Bundle\CandTestBundle\Entity\Wedding;
use Julian\Bundle\CandTestBundle\Entity\Guest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GuestBookController extends Controller
{
    /**
     *
     * Action to handle landing page for guestbook
     * Allows creation and viewing of messages for specified wedding
     * @param string $slug
     *
     */
    public function indexAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $wedding = $em->getRepository('JulianCandTestBundle:Wedding')->findBySlug($slug);
        $existingGuests = $em->getRepository('JulianCandTestBundle:Guest')->findByWeddingId($wedding[0]->getId());

        $guest = new Guest();

        $form = $this->createFormBuilder($guest)
            ->add('name', 'text')
            ->add('message', 'text')
            ->add('photo', 'file')
            ->add('Create', 'submit')
            ->getForm();

        $request = $this->getRequest();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $files = $this->get('request')->files->get('form');
            $file = $files['photo'];

            //Photo should probably be a foreign key linking to an image table
            //This would allow more validation to be applied
            $extension = $file->guessExtension();
            $newFileName = rand(1, 9999999).'.'.$extension;

            $dir = "uploads/";

            $file->move($dir, $newFileName);

            $guest->setWeddingId($wedding[0]->getId());     
            $guest->setCreated(new \DateTime());
            $guest->setPhoto($newFileName);

            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($guest);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Guest message added successfully!'
            );
            return $this->redirect($this->generateUrl('guestbook',array('slug' => $slug)));
        }

        return $this->render('JulianCandTestBundle:GuestBook:index.html.twig', array('form' => $form->createView(), 'wedding' => $wedding[0], 'guests' => $existingGuests));
    }



}
