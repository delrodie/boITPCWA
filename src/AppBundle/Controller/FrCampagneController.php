<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FrCampagne;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frcampagne controller.
 *
 * @Route("backend/frcampagne")
 */
class FrCampagneController extends Controller
{
    /**
     * Lists all frCampagne entities.
     *
     * @Route("/", name="backend_frcampagne_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frCampagnes = $em->getRepository('AppBundle:FrCampagne')->findAll();

        return $this->render('frcampagne/index.html.twig', array(
            'frCampagnes' => $frCampagnes,
        ));
    }

    /**
     * Creates a new frCampagne entity.
     *
     * @Route("/new", name="backend_frcampagne_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $frCampagne = new Frcampagne();
        $form = $this->createForm('AppBundle\Form\FrCampagneType', $frCampagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($frCampagne->getContenu(), 450, '...', true);
            $frCampagne->setResume($resume);
            $em->persist($frCampagne);
            $em->flush();

            return $this->redirectToRoute('backend_frcampagne_show', array('slug' => $frCampagne->getSlug()));
        }

        return $this->render('frcampagne/new.html.twig', array(
            'frCampagne' => $frCampagne,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frCampagne entity.
     *
     * @Route("/{slug}", name="backend_frcampagne_show")
     * @Method("GET")
     */
    public function showAction(FrCampagne $frCampagne)
    {
        $deleteForm = $this->createDeleteForm($frCampagne);

        return $this->render('frcampagne/show.html.twig', array(
            'frCampagne' => $frCampagne,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frCampagne entity.
     *
     * @Route("/{slug}/edit", name="backend_frcampagne_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FrCampagne $frCampagne, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($frCampagne);
        $editForm = $this->createForm('AppBundle\Form\FrCampagneType', $frCampagne);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($frCampagne->getContenu(), 450, '...', true);
            $frCampagne->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_frcampagne_index');
        }

        return $this->render('frcampagne/edit.html.twig', array(
            'frCampagne' => $frCampagne,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frCampagne entity.
     *
     * @Route("/{id}", name="backend_frcampagne_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FrCampagne $frCampagne)
    {
        $form = $this->createDeleteForm($frCampagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frCampagne);
            $em->flush();
        }

        return $this->redirectToRoute('backend_frcampagne_index');
    }

    /**
     * Creates a form to delete a frCampagne entity.
     *
     * @param FrCampagne $frCampagne The frCampagne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FrCampagne $frCampagne)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_frcampagne_delete', array('id' => $frCampagne->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
