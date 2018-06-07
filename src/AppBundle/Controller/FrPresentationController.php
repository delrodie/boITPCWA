<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FrPresentation;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frpresentation controller.
 *
 * @Route("backend/frpresentation")
 */
class FrPresentationController extends Controller
{
    /**
     * Lists all frPresentation entities.
     *
     * @Route("/", name="backend_frpresentation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frPresentations = $em->getRepository('AppBundle:FrPresentation')->findAll();

        return $this->render('frpresentation/index.html.twig', array(
            'frPresentations' => $frPresentations,
        ));
    }

    /**
     * Creates a new frPresentation entity.
     *
     * @Route("/new", name="backend_frpresentation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $frPresentation = new Frpresentation();
        $form = $this->createForm('AppBundle\Form\FrPresentationType', $frPresentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($frPresentation->getContenu(), 200, '...', true);
            $resumeIntro = $utilities->resume($frPresentation->getContenu(), 500, '...', true);
            $frPresentation->setResume($resume);
            $frPresentation->setResumeintro($resumeIntro);
            $em->persist($frPresentation);
            $em->flush();

            return $this->redirectToRoute('backend_frpresentation_show', array('slug' => $frPresentation->getSlug()));
        }

        return $this->render('frpresentation/new.html.twig', array(
            'frPresentation' => $frPresentation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frPresentation entity.
     *
     * @Route("/{slug}", name="backend_frpresentation_show")
     * @Method("GET")
     */
    public function showAction(FrPresentation $frPresentation)
    {
        $deleteForm = $this->createDeleteForm($frPresentation);

        return $this->render('frpresentation/show.html.twig', array(
            'frPresentation' => $frPresentation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frPresentation entity.
     *
     * @Route("/{slug}/edit", name="backend_frpresentation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FrPresentation $frPresentation, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($frPresentation);
        $editForm = $this->createForm('AppBundle\Form\FrPresentationType', $frPresentation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($frPresentation->getContenu(), 200, '...', true);
            $resumeIntro = $utilities->resume($frPresentation->getContenu(), 500, '...', true);
            $frPresentation->setResume($resume);
            $frPresentation->setResumeintro($resumeIntro);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_frpresentation_show', array('slug' => $frPresentation->getSlug()));
        }

        return $this->render('frpresentation/edit.html.twig', array(
            'frPresentation' => $frPresentation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frPresentation entity.
     *
     * @Route("/{id}", name="backend_frpresentation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FrPresentation $frPresentation)
    {
        $form = $this->createDeleteForm($frPresentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frPresentation);
            $em->flush();
        }

        return $this->redirectToRoute('backend_frpresentation_index');
    }

    /**
     * Creates a form to delete a frPresentation entity.
     *
     * @param FrPresentation $frPresentation The frPresentation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FrPresentation $frPresentation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_frpresentation_delete', array('id' => $frPresentation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
