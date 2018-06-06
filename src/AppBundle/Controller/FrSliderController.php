<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FrSlider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frslider controller.
 *
 * @Route("backend/frslider")
 */
class FrSliderController extends Controller
{
    /**
     * Lists all frSlider entities.
     *
     * @Route("/", name="backend_frslider_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frSliders = $em->getRepository('AppBundle:FrSlider')->boListDesc(9,0);

        return $this->render('frslider/index.html.twig', array(
            'frSliders' => $frSliders,
        ));
    }

    /**
     * Creates a new frSlider entity.
     *
     * @Route("/new", name="backend_frslider_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $frSlider = new Frslider();
        $form = $this->createForm('AppBundle\Form\FrSliderType', $frSlider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($frSlider);
            $em->flush();

            return $this->redirectToRoute('backend_frslider_show', array('slug' => $frSlider->getSlug()));
        }

        return $this->render('frslider/new.html.twig', array(
            'frSlider' => $frSlider,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frSlider entity.
     *
     * @Route("/{slug}", name="backend_frslider_show")
     * @Method("GET")
     */
    public function showAction(FrSlider $frSlider)
    {
        $deleteForm = $this->createDeleteForm($frSlider);

        return $this->render('frslider/show.html.twig', array(
            'frSlider' => $frSlider,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frSlider entity.
     *
     * @Route("/{slug}/edit", name="backend_frslider_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FrSlider $frSlider)
    {
        $deleteForm = $this->createDeleteForm($frSlider);
        $editForm = $this->createForm('AppBundle\Form\FrSliderType', $frSlider);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_frslider_show', array('slug' => $frSlider->getSlug()));
        }

        return $this->render('frslider/edit.html.twig', array(
            'frSlider' => $frSlider,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frSlider entity.
     *
     * @Route("/{id}", name="backend_frslider_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FrSlider $frSlider)
    {
        $form = $this->createDeleteForm($frSlider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frSlider);
            $em->flush();
        }

        return $this->redirectToRoute('backend_frslider_index');
    }

    /**
     * Creates a form to delete a frSlider entity.
     *
     * @param FrSlider $frSlider The frSlider entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FrSlider $frSlider)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_frslider_delete', array('id' => $frSlider->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
