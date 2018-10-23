<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EnWelcome;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Enwelcome controller.
 *
 * @Route("backend/enwelcome")
 */
class EnWelcomeController extends Controller
{
    /**
     * Lists all enWelcome entities.
     *
     * @Route("/", name="backend_enwelcome_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enWelcomes = $em->getRepository('AppBundle:EnWelcome')->findAll();

        return $this->render('enwelcome/index.html.twig', array(
            'enWelcomes' => $enWelcomes,
        ));
    }

    /**
     * Creates a new enWelcome entity.
     *
     * @Route("/new", name="backend_enwelcome_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $enWelcome = new Enwelcome();
        $form = $this->createForm('AppBundle\Form\EnWelcomeType', $enWelcome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($enWelcome->getContenu(), 200, '...', true);
            $resumeIntro = $utilities->resume($enWelcome->getContenu(), 500, '...', true);
            $enWelcome->setResume($resume);
            $enWelcome->setResumeintro($resumeIntro);
            $em->persist($enWelcome);
            $em->flush();

            return $this->redirectToRoute('backend_enwelcome_show', array('slug' => $enWelcome->getSlug()));
        }

        return $this->render('enwelcome/new.html.twig', array(
            'enWelcome' => $enWelcome,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enWelcome entity.
     *
     * @Route("/{slug}", name="backend_enwelcome_show")
     * @Method("GET")
     */
    public function showAction(EnWelcome $enWelcome)
    {
        $deleteForm = $this->createDeleteForm($enWelcome);

        return $this->render('enwelcome/show.html.twig', array(
            'enWelcome' => $enWelcome,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enWelcome entity.
     *
     * @Route("/{slug}/edit", name="backend_enwelcome_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EnWelcome $enWelcome, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($enWelcome);
        $editForm = $this->createForm('AppBundle\Form\EnWelcomeType', $enWelcome);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($enWelcome->getContenu(), 200, '...', true);
            $resumeIntro = $utilities->resume($enWelcome->getContenu(), 500, '...', true);
            $enWelcome->setResume($resume);
            $enWelcome->setResumeintro($resumeIntro);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_enwelcome_show', array('slug' => $enWelcome->getSlug()));
        }

        return $this->render('enwelcome/edit.html.twig', array(
            'enWelcome' => $enWelcome,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enWelcome entity.
     *
     * @Route("/{id}", name="backend_enwelcome_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EnWelcome $enWelcome)
    {
        $form = $this->createDeleteForm($enWelcome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enWelcome);
            $em->flush();
        }

        return $this->redirectToRoute('backend_enwelcome_index');
    }

    /**
     * Creates a form to delete a enWelcome entity.
     *
     * @param EnWelcome $enWelcome The enWelcome entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EnWelcome $enWelcome)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_enwelcome_delete', array('id' => $enWelcome->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
