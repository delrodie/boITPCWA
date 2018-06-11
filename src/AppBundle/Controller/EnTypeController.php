<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EnType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Entype controller.
 *
 * @Route("backend/entype")
 */
class EnTypeController extends Controller
{
    /**
     * Lists all enType entities.
     *
     * @Route("/", name="backend_entype_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $enType = new Entype();
        $form = $this->createForm('AppBundle\Form\EnTypeType', $enType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enType);
            $em->flush();

            return $this->redirectToRoute('backend_entype_index');
        }

        $enTypes = $em->getRepository('AppBundle:EnType')->findAll();

        return $this->render('entype/index.html.twig', array(
            'enTypes' => $enTypes,
            'enType' => $enType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new enType entity.
     *
     * @Route("/new", name="backend_entype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $enType = new Entype();
        $form = $this->createForm('AppBundle\Form\EnTypeType', $enType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enType);
            $em->flush();

            return $this->redirectToRoute('backend_entype_show', array('id' => $enType->getId()));
        }

        return $this->render('entype/new.html.twig', array(
            'enType' => $enType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enType entity.
     *
     * @Route("/{id}", name="backend_entype_show")
     * @Method("GET")
     */
    public function showAction(EnType $enType)
    {
        $deleteForm = $this->createDeleteForm($enType);

        return $this->render('entype/show.html.twig', array(
            'enType' => $enType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enType entity.
     *
     * @Route("/{slug}/edit", name="backend_entype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EnType $enType)
    {
        $deleteForm = $this->createDeleteForm($enType);
        $editForm = $this->createForm('AppBundle\Form\EnTypeType', $enType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_entype_index');
        }
        $em = $this->getDoctrine()->getManager();

        $enTypes = $em->getRepository('AppBundle:EnType')->findAll();

        return $this->render('entype/edit.html.twig', array(
            'enType' => $enType,
            'enTypes' => $enTypes,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enType entity.
     *
     * @Route("/{id}", name="backend_entype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EnType $enType)
    {
        $form = $this->createDeleteForm($enType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enType);
            $em->flush();
        }

        return $this->redirectToRoute('backend_entype_index');
    }

    /**
     * Creates a form to delete a enType entity.
     *
     * @param EnType $enType The enType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EnType $enType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_entype_delete', array('id' => $enType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
