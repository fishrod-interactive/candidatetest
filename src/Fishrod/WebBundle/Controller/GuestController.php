<?php

namespace Fishrod\WebBundle\Controller;

use Fishrod\GuestBundle\Entity\Guest;
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
     * @Route("/create")
     * @param Request $request
     * @param Wedding $wedding
     * @return array
     */
    public function createGuestEntryAction(Request $request, Wedding $wedding)
    {
        $guest = new Guest();
        $form = $this->createForm(new GuestEntryType(), $guest);

        $form->add('submit', 'submit', array('label' => 'Submit'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $guest->setWedding($wedding);

            $em = $this->getDoctrine()->getManager();
            $em->persist($guest);
            $em->flush();

            return $this->redirectToRoute(
                'admin_wedding_view',
                ['id' => $guest->getId()]
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