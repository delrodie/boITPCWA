<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EnCampaign;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Encampaign controller.
 *
 * @Route("backend/encampaign")
 */
class EnCampaignController extends Controller
{
    /**
     * Lists all enCampaign entities.
     *
     * @Route("/", name="backend_encampaign_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enCampaigns = $em->getRepository('AppBundle:EnCampaign')->findAll();

        return $this->render('encampaign/index.html.twig', array(
            'enCampaigns' => $enCampaigns,
        ));
    }

    /**
     * Creates a new enCampaign entity.
     *
     * @Route("/new", name="backend_encampaign_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $enCampaign = new Encampaign();
        $form = $this->createForm('AppBundle\Form\EnCampaignType', $enCampaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($enCampaign->getContenu(), 450, '...', true);
            $enCampaign->setResume($resume);
            $em->persist($enCampaign);
            $em->flush();

            return $this->redirectToRoute('backend_encampaign_show', array('slug' => $enCampaign->getSlug()));
        }

        return $this->render('encampaign/new.html.twig', array(
            'enCampaign' => $enCampaign,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enCampaign entity.
     *
     * @Route("/{slug}", name="backend_encampaign_show")
     * @Method("GET")
     */
    public function showAction(EnCampaign $enCampaign)
    {
        $deleteForm = $this->createDeleteForm($enCampaign);

        return $this->render('encampaign/show.html.twig', array(
            'enCampaign' => $enCampaign,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enCampaign entity.
     *
     * @Route("/{slug}/edit", name="backend_encampaign_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EnCampaign $enCampaign, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($enCampaign);
        $editForm = $this->createForm('AppBundle\Form\EnCampaignType', $enCampaign);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($enCampaign->getContenu(), 450, '...', true);
            $enCampaign->setResume($resume); //dump($enCampaign);die();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_encampaign_show', array('slug' => $enCampaign->getSlug()));
        }

        return $this->render('encampaign/edit.html.twig', array(
            'enCampaign' => $enCampaign,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enCampaign entity.
     *
     * @Route("/{id}", name="backend_encampaign_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EnCampaign $enCampaign)
    {
        $form = $this->createDeleteForm($enCampaign);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enCampaign);
            $em->flush();
        }

        return $this->redirectToRoute('backend_encampaign_index');
    }

    /**
     * Creates a form to delete a enCampaign entity.
     *
     * @param EnCampaign $enCampaign The enCampaign entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EnCampaign $enCampaign)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_encampaign_delete', array('id' => $enCampaign->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
