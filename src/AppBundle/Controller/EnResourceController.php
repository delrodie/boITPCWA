<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EnResource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Enresource controller.
 *
 * @Route("backend/enresource")
 */
class EnResourceController extends Controller
{
    /**
     * Lists all enResource entities.
     *
     * @Route("/", name="backend_enresource_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enResources = $em->getRepository('AppBundle:EnResource')->findAll();

        return $this->render('enresource/index.html.twig', array(
            'enResources' => $enResources,
        ));
    }

    /**
     * Creates a new enResource entity.
     *
     * @Route("/new", name="backend_enresource_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $enResource = new Enresource();
        $form = $this->createForm('AppBundle\Form\EnResourceType', $enResource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($enResource);
            $em->flush();

            return $this->redirectToRoute('backend_enresource_index');
        }

        return $this->render('enresource/new.html.twig', array(
            'enResource' => $enResource,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enResource entity.
     *
     * @Route("/{id}", name="backend_enresource_show")
     * @Method("GET")
     */
    public function showAction(EnResource $enResource)
    {
        $deleteForm = $this->createDeleteForm($enResource);

        return $this->render('enresource/show.html.twig', array(
            'enResource' => $enResource,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enResource entity.
     *
     * @Route("/{slug}/edit", name="backend_enresource_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EnResource $enResource)
    {
        $deleteForm = $this->createDeleteForm($enResource);
        $editForm = $this->createForm('AppBundle\Form\EnResourceType', $enResource);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_enresource_index');
        }

        return $this->render('enresource/edit.html.twig', array(
            'enResource' => $enResource,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enResource entity.
     *
     * @Route("/{id}", name="backend_enresource_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EnResource $enResource)
    {
        $form = $this->createDeleteForm($enResource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enResource);
            $em->flush();
        }

        return $this->redirectToRoute('backend_enresource_index');
    }

    /**
     * Creates a form to delete a enResource entity.
     *
     * @param EnResource $enResource The enResource entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EnResource $enResource)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_enresource_delete', array('id' => $enResource->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
