<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FrJob;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frjob controller.
 *
 * @Route("backend/frjob")
 */
class FrJobController extends Controller
{
    /**
     * Lists all frJob entities.
     *
     * @Route("/", name="backend_frjob_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frJobs = $em->getRepository('AppBundle:FrJob')->findListDESC();

        return $this->render('frjob/index.html.twig', array(
            'frJobs' => $frJobs,
        ));
    }

    /**
     * Creates a new frJob entity.
     *
     * @Route("/new", name="backend_frjob_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $frJob = new Frjob();
        $form = $this->createForm('AppBundle\Form\FrJobType', $frJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($frJob->getDescription(), 300, '...', true);
            $frJob->setResume($resume);
            $em->persist($frJob);
            $em->flush();

            return $this->redirectToRoute('backend_frjob_show', array('slug' => $frJob->getSlug()));
        }

        return $this->render('frjob/new.html.twig', array(
            'frJob' => $frJob,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frJob entity.
     *
     * @Route("/{slug}", name="backend_frjob_show")
     * @Method("GET")
     */
    public function showAction(FrJob $frJob)
    {
        $deleteForm = $this->createDeleteForm($frJob);

        return $this->render('frjob/show.html.twig', array(
            'frJob' => $frJob,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frJob entity.
     *
     * @Route("/{slug}/edit", name="backend_frjob_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FrJob $frJob, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($frJob);
        $editForm = $this->createForm('AppBundle\Form\FrJobType', $frJob);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($frJob->getDescription(), 300, '...', true);
            $frJob->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_frjob_show', array('slug' => $frJob->getSlug()));
        }

        return $this->render('frjob/edit.html.twig', array(
            'frJob' => $frJob,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frJob entity.
     *
     * @Route("/{id}", name="backend_frjob_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FrJob $frJob)
    {
        $form = $this->createDeleteForm($frJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frJob);
            $em->flush();
        }

        return $this->redirectToRoute('backend_frjob_index');
    }

    /**
     * Creates a form to delete a frJob entity.
     *
     * @param FrJob $frJob The frJob entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FrJob $frJob)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_frjob_delete', array('id' => $frJob->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
