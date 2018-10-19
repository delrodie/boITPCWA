<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FrBienvenue;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frbienvenue controller.
 *
 * @Route("backend/frbienvenue")
 */
class FrBienvenueController extends Controller
{
    /**
     * Lists all frBienvenue entities.
     *
     * @Route("/", name="backend_frbienvenue_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frBienvenues = $em->getRepository('AppBundle:FrBienvenue')->findAll();

        return $this->render('frbienvenue/index.html.twig', array(
            'frBienvenues' => $frBienvenues,
        ));
    }

    /**
     * Creates a new frBienvenue entity.
     *
     * @Route("/new", name="backend_frbienvenue_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $frBienvenue = new Frbienvenue();
        $form = $this->createForm('AppBundle\Form\FrBienvenueType', $frBienvenue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($frBienvenue->getContenu(), 200, '...', true);
            $resumeIntro = $utilities->resume($frBienvenue->getContenu(), 500, '...', true);
            $frBienvenue->setResume($resume);
            $frBienvenue->setResumeintro($resumeIntro);
            $em->persist($frBienvenue);
            $em->flush();

            return $this->redirectToRoute('backend_frbienvenue_show', array('slug' => $frBienvenue->getSlug()));
        }

        return $this->render('frbienvenue/new.html.twig', array(
            'frBienvenue' => $frBienvenue,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frBienvenue entity.
     *
     * @Route("/{slug}", name="backend_frbienvenue_show")
     * @Method("GET")
     */
    public function showAction(FrBienvenue $frBienvenue)
    {
        $deleteForm = $this->createDeleteForm($frBienvenue);

        return $this->render('frbienvenue/show.html.twig', array(
            'frBienvenue' => $frBienvenue,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frBienvenue entity.
     *
     * @Route("/{slug}/edit", name="backend_frbienvenue_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FrBienvenue $frBienvenue)
    {
        $deleteForm = $this->createDeleteForm($frBienvenue);
        $editForm = $this->createForm('AppBundle\Form\FrBienvenueType', $frBienvenue);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_frbienvenue_show', array('slug' => $frBienvenue->getSlug()));
        }

        return $this->render('frbienvenue/edit.html.twig', array(
            'frBienvenue' => $frBienvenue,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frBienvenue entity.
     *
     * @Route("/{id}", name="backend_frbienvenue_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FrBienvenue $frBienvenue)
    {
        $form = $this->createDeleteForm($frBienvenue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frBienvenue);
            $em->flush();
        }

        return $this->redirectToRoute('backend_frbienvenue_index');
    }

    /**
     * Creates a form to delete a frBienvenue entity.
     *
     * @param FrBienvenue $frBienvenue The frBienvenue entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FrBienvenue $frBienvenue)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_frbienvenue_delete', array('id' => $frBienvenue->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
