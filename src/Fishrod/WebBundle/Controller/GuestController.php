<?php

namespace Fishrod\WebBundle\Controller;

use Fishrod\GuestBundle\Entity\Guest;
use Fishrod\MediaBundle\Entity\Photo;
use Fishrod\WebBundle\Form\GuestEntryType;
use Fishrod\WeddingBundle\Entity\Wedding;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/guest")
 * @Template()
 */
class GuestController extends Controller
{
    /**
     * @Route("/create/{id}", name="web_guest_create")
     * @param Request $request
     * @param Wedding $wedding
     * @return array
     */
    public function createGuestEntryAction(Request $request, $id = null)
    {
        $guest = new Guest();
        $wedding = $this->getDoctrine()->getRepository('FishrodWeddingBundle:Wedding')
            ->find($id);
        $guest->setWedding($wedding);

        $form = $this->createForm(new GuestEntryType(), $guest);
        $form->add('submit', 'submit', array('label' => 'Create'));
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // Handle File
            $file = new Photo();
            $guest->getPhoto()->upload();

            $em->persist($guest);
            $em->flush();

            return $this->redirectToRoute(
                'fishrod_web_wedding_view',
                ['slug' => $wedding->getSlug()]
            );
        }

        return $this->render(
            'FishrodWebBundle:Guest:create.html.twig',
            [
                'entity' => $guest,
                'form'   => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param Wedding $wedding
     * @return array
     */
    public function viewGuestMessagesWidgetAction(Request $request, Wedding $wedding)
    {
        $guests = $this->getDoctrine()->getManager()
            ->getRepository('FishrodGuestBundle:Guest')
            ->findBy(['wedding' => $wedding]);

        return $this->render(
            'FishrodWebBundle:Guest:weddingMessages.html.twig',
            [
                'guests' => $guests
            ]
        );
    }
}