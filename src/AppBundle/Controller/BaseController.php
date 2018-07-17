<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Base;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Base controller.
 *
 * @Route("base")
 */
class BaseController extends Controller
{
    /**
     * Lists all base entities.
     *
     * @Route("/", name="base_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bases = $em->getRepository('AppBundle:Base')->findAll();

        return $this->render('base/index.html.twig', array(
            'bases' => $bases,
        ));
    }

    /**
     * Creates a new base entity.
     *
     * @Route("/new", name="base_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $base = new Base();
        $form = $this->createForm('AppBundle\Form\BaseType', $base);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($base);
            $em->flush();

            return $this->redirectToRoute('base_show', array('id' => $base->getId()));
        }

        return $this->render('base/new.html.twig', array(
            'base' => $base,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a base entity.
     *
     * @Route("/{id}", name="base_show")
     * @Method("GET")
     */
    public function showAction(Base $base)
    {
        $deleteForm = $this->createDeleteForm($base);

        return $this->render('base/show.html.twig', array(
            'base' => $base,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing base entity.
     *
     * @Route("/{id}/edit", name="base_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Base $base)
    {
        $deleteForm = $this->createDeleteForm($base);
        $editForm = $this->createForm('AppBundle\Form\BaseType', $base);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('base_edit', array('id' => $base->getId()));
        }

        return $this->render('base/edit.html.twig', array(
            'base' => $base,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a base entity.
     *
     * @Route("/{id}", name="base_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Base $base)
    {
        $form = $this->createDeleteForm($base);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($base);
            $em->flush();
        }

        return $this->redirectToRoute('base_index');
    }

    /**
     * Creates a form to delete a base entity.
     *
     * @param Base $base The base entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Base $base)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('base_delete', array('id' => $base->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
