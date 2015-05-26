<?php

namespace Fishrod\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fishrod\WeddingBundle\Entity\Wedding;
use Fishrod\AdminBundle\Form\WeddingType;

/**
 * Wedding controller.
 *
 * @Route("/admin/wedding")
 */
class WeddingController extends Controller
{

    /**
     * Lists all Wedding entities.
     *
     * @Route("/", name="admin_wedding")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FishrodWeddingBundle:Wedding')->findAll();

        return $this->render(
            'FishrodAdminBundle:Wedding:index.html.twig',
            ['entities' => $entities]
        );
    }
    /**
     * Creates a new Wedding entity.
     *
     * @Route("/create", name="admin_wedding_create")
     */
    public function createAction(Request $request)
    {
        $entity = new Wedding();
        $form = $this->createForm(new WeddingType(), $entity );

        $form->add('submit', 'submit', array('label' => 'Create'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectToRoute(
                'admin_wedding_view',
                ['id' => $entity->getId()]
            );
        }

        return $this->render(
            'FishrodAdminBundle:Wedding:create.html.twig',
            [
            'entity' => $entity,
            'form'   => $form->createView(),
            ]
        );
    }

    /**
     * Finds and displays a Wedding entity.
     *
     * @Route("/view/{id}", name="admin_wedding_view")
     * @Method("GET")
     * @Template()
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FishrodWeddingBundle:Wedding')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wedding entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'FishrodAdminBundle:Wedding:view.html.twig',
            [
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView()
            ]
        );
    }

    /**
     * Displays a form to edit an existing Wedding entity.
     *
     * @Route("/edit/{id}", name="admin_wedding_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FishrodWeddingBundle:Wedding')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wedding entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Wedding entity.
    *
    * @param Wedding $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Wedding $entity)
    {
        $form = $this->createForm(new WeddingType(), $entity, array(
            'action' => $this->generateUrl('admin_wedding_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Wedding entity.
     *
     * @Route("/{id}", name="admin_wedding_update")
     * @Method("PUT")
     * @Template("FishrodAdminBundle:Wedding:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FishrodWeddingBundle:Wedding')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wedding entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_wedding_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Wedding entity.
     *
     * @Route("/{id}", name="admin_wedding_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FishrodWeddingBundle:Wedding')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Wedding entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_wedding'));
    }

    /**
     * Creates a form to delete a Wedding entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_wedding_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
