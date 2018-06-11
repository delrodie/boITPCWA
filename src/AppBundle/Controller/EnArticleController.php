<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EnArticle;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Enarticle controller.
 *
 * @Route("backend/enarticle")
 */
class EnArticleController extends Controller
{
    /**
     * Lists all enArticle entities.
     *
     * @Route("/", name="backend_enarticle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $enArticles = $em->getRepository('AppBundle:EnArticle')->findArticleDesc(9,0);

        return $this->render('enarticle/index.html.twig', array(
            'enArticles' => $enArticles,
        ));
    }

    /**
     * Creates a new enArticle entity.
     *
     * @Route("/new", name="backend_enarticle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $enArticle = new Enarticle();
        $form = $this->createForm('AppBundle\Form\EnArticleType', $enArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($enArticle->getContenu(), 200, '...', true);
            $enArticle->setResume($resume);
            $em->persist($enArticle);
            $em->flush();

            return $this->redirectToRoute('backend_enarticle_show', array('slug' => $enArticle->getSlug()));
        }

        return $this->render('enarticle/new.html.twig', array(
            'enArticle' => $enArticle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a enArticle entity.
     *
     * @Route("/{slug}", name="backend_enarticle_show")
     * @Method("GET")
     */
    public function showAction(EnArticle $enArticle)
    {
        $deleteForm = $this->createDeleteForm($enArticle);

        return $this->render('enarticle/show.html.twig', array(
            'enArticle' => $enArticle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing enArticle entity.
     *
     * @Route("/{slug}/edit", name="backend_enarticle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EnArticle $enArticle, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($enArticle);
        $editForm = $this->createForm('AppBundle\Form\EnArticleType', $enArticle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($enArticle->getContenu(), 200, '...', true);
            $enArticle->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_enarticle_show', array('slug' => $enArticle->getSlug()));
        }

        return $this->render('enarticle/edit.html.twig', array(
            'enArticle' => $enArticle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a enArticle entity.
     *
     * @Route("/{id}", name="backend_enarticle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EnArticle $enArticle)
    {
        $form = $this->createDeleteForm($enArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($enArticle);
            $em->flush();
        }

        return $this->redirectToRoute('backend_enarticle_index');
    }

    /**
     * Creates a form to delete a enArticle entity.
     *
     * @param EnArticle $enArticle The enArticle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EnArticle $enArticle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_enarticle_delete', array('id' => $enArticle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
