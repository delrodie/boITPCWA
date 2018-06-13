<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FrArticle;
use AppBundle\Entity\Traduction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Traduction controller.
 *
 * @Route("backend/traduction")
 */
class TraductionController extends Controller
{
    /**
     * Lists all traduction entities.
     *
     * @Route("/", name="backend_traduction_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $traductions = $em->getRepository('AppBundle:Traduction')->findAll();

        return $this->render('traduction/index.html.twig', array(
            'traductions' => $traductions,
        ));
    }

    /**
     * Creates a new traduction entity.
     *
     * @Route("/new/{fr}/{en}", name="backend_traduction_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $fr, $en)
    {
        $em = $this->getDoctrine()->getManager();
        $verifEnArticle = $em->getRepository('AppBundle:Traduction')->findOneBy(array('anglais'=> $en));
        $verifFrArticle = $em->getRepository('AppBundle:Traduction')->findOneBy(array('francais'=> $fr));
        if ($verifEnArticle) return $this->redirectToRoute('backend_traduction_show', array('id'=> $verifEnArticle->getId()));
        if ($verifFrArticle) return $this->redirectToRoute('backend_traduction_show', array('id'=> $verifFrArticle->getId()));

        //$result = $em->getRepository('AppBundle:FrArticle')->findFrArticle($fr)->getQuery()->getResult(); dump($result);die();

        $traduction = new Traduction();
        $form = $this->createForm('AppBundle\Form\TraductionType', $traduction, array('fr'=> $fr, 'en'=> $en));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager(); //dump($traduction->getFrancais()->getId()); die();
            $em->persist($traduction);
            $em->flush();

            $francais = $em->getRepository('AppBundle:FrArticle')->findOneBy(array('id'=> $traduction->getFrancais()->getId()));
            $francais->setTraduction(true);

            $anglais = $em->getRepository('AppBundle:EnArticle')->findOneBy(array('id'=> $traduction->getAnglais()->getId()));
            $anglais->setTraduction(true);
            $em->flush();

            return $this->redirectToRoute('backend_traduction_show', array('id' => $traduction->getId()));
        }

        return $this->render('traduction/new.html.twig', array(
            'traduction' => $traduction,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a traduction entity.
     *
     * @Route("/{id}", name="backend_traduction_show")
     * @Method("GET")
     */
    public function showAction(Traduction $traduction)
    {
        $deleteForm = $this->createDeleteForm($traduction);

        return $this->render('traduction/show.html.twig', array(
            'traduction' => $traduction,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing traduction entity.
     *
     * @Route("/{id}/edit/{fr}/{en}", name="backend_traduction_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Traduction $traduction, $fr, $en)
    {
        $deleteForm = $this->createDeleteForm($traduction);
        $editForm = $this->createForm('AppBundle\Form\TraductionEditType', $traduction, array('fr'=> $fr, 'en'=>$en));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();


            if ($fr != $traduction->getFrancais()->getId()){
                $ancienFrancais = $em->getRepository('AppBundle:FrArticle')->findOneBy(array('id'=> $fr));
                $francais = $em->getRepository('AppBundle:FrArticle')->findOneBy(array('id'=> $traduction->getFrancais()->getId()));
                $francais->setTraduction(true);
                $ancienFrancais->setTraduction(false);
            }

            if ($en != $traduction->getAnglais()->getId()){
                $ancienAnglais = $em->getRepository('AppBundle:EnArticle')->findOneBy(array('id'=> $en));
                $anglais = $em->getRepository('AppBundle:EnArticle')->findOneBy(array('id'=> $traduction->getAnglais()->getId()));
                $anglais->setTraduction(true);
                $ancienAnglais->setTraduction(false);
            }

            $em->flush();

            return $this->redirectToRoute('backend_traduction_show', array('id' => $traduction->getId()));
        }

        return $this->render('traduction/edit.html.twig', array(
            'traduction' => $traduction,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a traduction entity.
     *
     * @Route("/{id}", name="backend_traduction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Traduction $traduction)
    {
        $form = $this->createDeleteForm($traduction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($traduction);
            $em->flush();
        }

        return $this->redirectToRoute('backend_traduction_index');
    }

    /**
     * Creates a form to delete a traduction entity.
     *
     * @param Traduction $traduction The traduction entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Traduction $traduction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_traduction_delete', array('id' => $traduction->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
