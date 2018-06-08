<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Partenaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Partenaire controller.
 *
 * @Route("backend/partenaire")
 */
class PartenaireController extends Controller
{
    /**
     * Lists all partenaire entities.
     *
     * @Route("/", name="backend_partenaire_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $partenaires = $em->getRepository('AppBundle:Partenaire')->findAll();

        return $this->render('partenaire/index.html.twig', array(
            'partenaires' => $partenaires,
        ));
    }

    /**
     * Creates a new partenaire entity.
     *
     * @Route("/new", name="backend_partenaire_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $partenaire = new Partenaire();
        $form = $this->createForm('AppBundle\Form\PartenaireType', $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($partenaire);
            $em->flush();

            return $this->redirectToRoute('backend_partenaire_index');
        }

        return $this->render('partenaire/new.html.twig', array(
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a partenaire entity.
     *
     * @Route("/{slug}", name="backend_partenaire_show")
     * @Method("GET")
     */
    public function showAction(Partenaire $partenaire)
    {
        $deleteForm = $this->createDeleteForm($partenaire);

        return $this->render('partenaire/show.html.twig', array(
            'partenaire' => $partenaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing partenaire entity.
     *
     * @Route("/{slug}/edit", name="backend_partenaire_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Partenaire $partenaire)
    {
        $deleteForm = $this->createDeleteForm($partenaire);
        $editForm = $this->createForm('AppBundle\Form\PartenaireType', $partenaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_partenaire_index');
        }

        return $this->render('partenaire/edit.html.twig', array(
            'partenaire' => $partenaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a partenaire entity.
     *
     * @Route("/{id}", name="backend_partenaire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Partenaire $partenaire)
    {
        $form = $this->createDeleteForm($partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($partenaire);
            $em->flush();
        }

        return $this->redirectToRoute('backend_partenaire_index');
    }

    /**
     * Creates a form to delete a partenaire entity.
     *
     * @param Partenaire $partenaire The partenaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partenaire $partenaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_partenaire_delete', array('id' => $partenaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
