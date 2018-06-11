<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EnPresentation;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Enpresentation controller.
 *
 * @Route("backend/enpresentation")
 */
class EnPresentationController extends Controller
{
    /**
     * Lists all enPresentation entities.
     *
     * @Route("/", name="backend_enpresentation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enPresentations = $em->getRepository('AppBundle:EnPresentation')->findAll();

        return $this->render('enpresentation/index.html.twig', array(
            'enPresentations' => $enPresentations,
        ));
    }

    /**
     * Creates a new enPresentation entity.
     *
     * @Route("/new", name="backend_enpresentation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $enPresentation = new Enpresentation();
        $form = $this->createForm('AppBundle\Form\EnPresentationType', $enPresentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($enPresentation->getContenu(), 200, '...', true);
            $resumeIntro = $utilities->resume($enPresentation->getContenu(), 500, '...', true);
            $enPresentation->setResume($resume);
            $enPresentation->setResumeintro($resumeIntro);
            $em->persist($enPresentation);
            $em->flush();

            return $this->redirectToRoute('backend_enpresentation_show', array('slug' => $enPresentation->getSlug()));
        }

        return $this->render('enpresentation/new.html.twig', array(
            'enPresentation' => $enPresentation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enPresentation entity.
     *
     * @Route("/{slug}", name="backend_enpresentation_show")
     * @Method("GET")
     */
    public function showAction(EnPresentation $enPresentation)
    {
        $deleteForm = $this->createDeleteForm($enPresentation);

        return $this->render('enpresentation/show.html.twig', array(
            'enPresentation' => $enPresentation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enPresentation entity.
     *
     * @Route("/{slug}/edit", name="backend_enpresentation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EnPresentation $enPresentation, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($enPresentation);
        $editForm = $this->createForm('AppBundle\Form\EnPresentationType', $enPresentation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($enPresentation->getContenu(), 200, '...', true);
            $resumeIntro = $utilities->resume($enPresentation->getContenu(), 500, '...', true);
            $enPresentation->setResume($resume);
            $enPresentation->setResumeintro($resumeIntro);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_enpresentation_show', array('slug' => $enPresentation->getSlug()));
        }

        return $this->render('enpresentation/edit.html.twig', array(
            'enPresentation' => $enPresentation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enPresentation entity.
     *
     * @Route("/{id}", name="backend_enpresentation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EnPresentation $enPresentation)
    {
        $form = $this->createDeleteForm($enPresentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enPresentation);
            $em->flush();
        }

        return $this->redirectToRoute('backend_enpresentation_index');
    }

    /**
     * Creates a form to delete a enPresentation entity.
     *
     * @param EnPresentation $enPresentation The enPresentation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EnPresentation $enPresentation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_enpresentation_delete', array('id' => $enPresentation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
