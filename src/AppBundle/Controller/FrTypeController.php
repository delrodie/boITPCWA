<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FrType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frtype controller.
 *
 * @Route("backend/frtype")
 */
class FrTypeController extends Controller
{
    /**
     * Lists all frType entities.
     *
     * @Route("/", name="backend_frtype_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $frType = new Frtype();
        $form = $this->createForm('AppBundle\Form\FrTypeType', $frType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($frType);
            $em->flush();

            return $this->redirectToRoute('backend_frtype_index');
        }

        $em = $this->getDoctrine()->getManager();

        $frTypes = $em->getRepository('AppBundle:FrType')->findAll();

        return $this->render('frtype/index.html.twig', array(
            'frTypes' => $frTypes,
            'frType' => $frType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new frType entity.
     *
     * @Route("/new", name="backend_frtype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $frType = new Frtype();
        $form = $this->createForm('AppBundle\Form\FrTypeType', $frType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($frType);
            $em->flush();

            return $this->redirectToRoute('backend_frtype_show', array('id' => $frType->getId()));
        }

        return $this->render('frtype/new.html.twig', array(
            'frType' => $frType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frType entity.
     *
     * @Route("/{id}", name="backend_frtype_show")
     * @Method("GET")
     */
    public function showAction(FrType $frType)
    {
        $deleteForm = $this->createDeleteForm($frType);

        return $this->render('frtype/show.html.twig', array(
            'frType' => $frType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frType entity.
     *
     * @Route("/{slug}/edit", name="backend_frtype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FrType $frType)
    {
        $deleteForm = $this->createDeleteForm($frType);
        $editForm = $this->createForm('AppBundle\Form\FrTypeType', $frType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_frtype_index');
        }

        $em = $this->getDoctrine()->getManager();

        $frTypes = $em->getRepository('AppBundle:FrType')->findAll();

        return $this->render('frtype/edit.html.twig', array(
            'frType' => $frType,
            'frTypes' => $frTypes,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frType entity.
     *
     * @Route("/{id}", name="backend_frtype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FrType $frType)
    {
        $form = $this->createDeleteForm($frType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frType);
            $em->flush();
        }

        return $this->redirectToRoute('backend_frtype_index');
    }

    /**
     * Creates a form to delete a frType entity.
     *
     * @param FrType $frType The frType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FrType $frType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_frtype_delete', array('id' => $frType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
