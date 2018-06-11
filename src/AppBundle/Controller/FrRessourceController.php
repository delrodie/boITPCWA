<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FrRessource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frressource controller.
 *
 * @Route("backend/frressource")
 */
class FrRessourceController extends Controller
{
    /**
     * Lists all frRessource entities.
     *
     * @Route("/", name="backend_frressource_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frRessources = $em->getRepository('AppBundle:FrRessource')->findRessourceDesc(9,0);

        return $this->render('frressource/index.html.twig', array(
            'frRessources' => $frRessources,
        ));
    }

    /**
     * Creates a new frRessource entity.
     *
     * @Route("/new", name="backend_frressource_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $frRessource = new Frressource();
        $form = $this->createForm('AppBundle\Form\FrRessourceType', $frRessource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($frRessource);
            $em->flush();

            return $this->redirectToRoute('backend_frressource_index');
        }

        return $this->render('frressource/new.html.twig', array(
            'frRessource' => $frRessource,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frRessource entity.
     *
     * @Route("/{id}", name="backend_frressource_show")
     * @Method("GET")
     */
    public function showAction(FrRessource $frRessource)
    {
        $deleteForm = $this->createDeleteForm($frRessource);

        return $this->render('frressource/show.html.twig', array(
            'frRessource' => $frRessource,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frRessource entity.
     *
     * @Route("/{slug}/edit", name="backend_frressource_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FrRessource $frRessource)
    {
        $deleteForm = $this->createDeleteForm($frRessource);
        $editForm = $this->createForm('AppBundle\Form\FrRessourceType', $frRessource);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_frressource_index');
        }

        return $this->render('frressource/edit.html.twig', array(
            'frRessource' => $frRessource,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frRessource entity.
     *
     * @Route("/{id}", name="backend_frressource_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FrRessource $frRessource)
    {
        $form = $this->createDeleteForm($frRessource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frRessource);
            $em->flush();
        }

        return $this->redirectToRoute('backend_frressource_index');
    }

    /**
     * Creates a form to delete a frRessource entity.
     *
     * @param FrRessource $frRessource The frRessource entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FrRessource $frRessource)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_frressource_delete', array('id' => $frRessource->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
