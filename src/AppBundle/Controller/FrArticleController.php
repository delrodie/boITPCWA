<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FrArticle;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frarticle controller.
 *
 * @Route("backend/frarticle")
 */
class FrArticleController extends Controller
{
    /**
     * Lists all frArticle entities.
     *
     * @Route("/", name="backend_frarticle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frArticles = $em->getRepository('AppBundle:FrArticle')->boListDesc(9, 0);

        return $this->render('frarticle/index.html.twig', array(
            'frArticles' => $frArticles,
        ));
    }

    /**
     * Creates a new frArticle entity.
     *
     * @Route("/new", name="backend_frarticle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $frArticle = new Frarticle();
        $form = $this->createForm('AppBundle\Form\FrArticleType', $frArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($frArticle->getContenu(), 200, '...', true);
            $frArticle->setResume($resume);
            $em->persist($frArticle);
            $em->flush();

            return $this->redirectToRoute('backend_frarticle_show', array('slug' => $frArticle->getSlug()));
        }

        return $this->render('frarticle/new.html.twig', array(
            'frArticle' => $frArticle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frArticle entity.
     *
     * @Route("/{slug}", name="backend_frarticle_show")
     * @Method("GET")
     */
    public function showAction(FrArticle $frArticle)
    {
        $deleteForm = $this->createDeleteForm($frArticle);

        return $this->render('frarticle/show.html.twig', array(
            'frArticle' => $frArticle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frArticle entity.
     *
     * @Route("/{slug}/edit", name="backend_frarticle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FrArticle $frArticle, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($frArticle);
        $editForm = $this->createForm('AppBundle\Form\FrArticleType', $frArticle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($frArticle->getContenu(), 200, '...', true);
            $frArticle->setResume($resume);//dump($resume);die();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_frarticle_show', array('slug' => $frArticle->getSlug()));
        }

        return $this->render('frarticle/edit.html.twig', array(
            'frArticle' => $frArticle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frArticle entity.
     *
     * @Route("/{id}", name="backend_frarticle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FrArticle $frArticle)
    {
        $form = $this->createDeleteForm($frArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frArticle);
            $em->flush();
        }

        return $this->redirectToRoute('backend_frarticle_index');
    }

    /**
     * Creates a form to delete a frArticle entity.
     *
     * @param FrArticle $frArticle The frArticle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FrArticle $frArticle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_frarticle_delete', array('id' => $frArticle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
