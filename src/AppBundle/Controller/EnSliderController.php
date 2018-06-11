<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EnSlider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Enslider controller.
 *
 * @Route("backend/enslider")
 */
class EnSliderController extends Controller
{
    /**
     * Lists all enSlider entities.
     *
     * @Route("/", name="backend_enslider_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enSliders = $em->getRepository('AppBundle:EnSlider')->findEnSliderDesc(9,0);

        return $this->render('enslider/index.html.twig', array(
            'enSliders' => $enSliders,
        ));
    }

    /**
     * Creates a new enSlider entity.
     *
     * @Route("/new", name="backend_enslider_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $enSlider = new Enslider();
        $form = $this->createForm('AppBundle\Form\EnSliderType', $enSlider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enSlider);
            $em->flush();

            return $this->redirectToRoute('backend_enslider_show', array('slug' => $enSlider->getSlug()));
        }

        return $this->render('enslider/new.html.twig', array(
            'enSlider' => $enSlider,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enSlider entity.
     *
     * @Route("/{slug}", name="backend_enslider_show")
     * @Method("GET")
     */
    public function showAction(EnSlider $enSlider)
    {
        $deleteForm = $this->createDeleteForm($enSlider);

        return $this->render('enslider/show.html.twig', array(
            'enSlider' => $enSlider,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enSlider entity.
     *
     * @Route("/{slug}/edit", name="backend_enslider_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EnSlider $enSlider)
    {
        $deleteForm = $this->createDeleteForm($enSlider);
        $editForm = $this->createForm('AppBundle\Form\EnSliderType', $enSlider);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_enslider_show', array('slug' => $enSlider->getSlug()));
        }

        return $this->render('enslider/edit.html.twig', array(
            'enSlider' => $enSlider,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enSlider entity.
     *
     * @Route("/{id}", name="backend_enslider_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EnSlider $enSlider)
    {
        $form = $this->createDeleteForm($enSlider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enSlider);
            $em->flush();
        }

        return $this->redirectToRoute('backend_enslider_index');
    }

    /**
     * Creates a form to delete a enSlider entity.
     *
     * @param EnSlider $enSlider The enSlider entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EnSlider $enSlider)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_enslider_delete', array('id' => $enSlider->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
