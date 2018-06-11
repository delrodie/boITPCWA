<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Photo controller.
 *
 * @Route("backend/photo")
 */
class PhotoController extends Controller
{
    /**
     * Lists all photo entities.
     *
     * @Route("/", name="backend_photo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $galleries = $em->getRepository('AppBundle:Photo')->findGallerie(9, 0); //dump($gallerie);die();

        return $this->render('photo/index.html.twig', array(
            'galleries' => $galleries,
        ));
    }

    /**
     * Creates a new photo entity.
     *
     * @Route("/new/{article}", name="backend_photo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $article)
    {
        $photo = new Photo();
        $form = $this->createForm('AppBundle\Form\PhotoType', $photo, array('article'=> $article));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            return $this->redirectToRoute('backend_photo_new', array('article' => $article));
        }

        $em = $this->getDoctrine()->getManager();
        $photos = $em->getRepository('AppBundle:Photo')->findBy(array('article'=> $article), array('id'=> 'DESC'));
        $retourArticle = $em->getRepository('AppBundle:FrArticle')->findOneBy(array('id'=> $article));

        return $this->render('photo/new.html.twig', array(
            'photo' => $photo,
            'article' => $article,
            'photos' => $photos,
            'retourArticle' => $retourArticle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Les photos des correspondantes a la gallerie
     *
     * @Route("/{article}", name="backend_gallerie_photo")
     * @Method("GET")
     */
    public function photoAction($article)
    {
        $em = $this->getDoctrine()->getManager();
        $photos = $em->getRepository('AppBundle:Photo')->findBy(array('article'=> $article));

        return $this->render('photo/show.html.twig',[
            'photos'    => $photos,
        ]);
    }

    /**
     * Finds and displays a photo entity.
     *
     * @Route("/{id}", name="backend_photo_show")
     * @Method("GET")
     */
    public function showAction(Photo $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);

        return $this->render('photo/show.html.twig', array(
            'photo' => $photo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing photo entity.
     *
     * @Route("/{id}/edit/{article}", name="backend_photo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Photo $photo, $article)
    {
        $deleteForm = $this->createDeleteForm($photo);
        $editForm = $this->createForm('AppBundle\Form\PhotoType', $photo, array('article'=> $article));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_photo_edit', array('id' => $photo->getId()));
        }

        $em = $this->getDoctrine()->getManager();
        $photos = $em->getRepository('AppBundle:Photo')->findBy(array('article'=> $article), array('id'=> 'DESC'));
        $retourArticle = $em->getRepository('AppBundle:FrArticle')->findOneBy(array('id'=> $article));


        return $this->render('photo/edit.html.twig', array(
            'photo' => $photo,
            'article' => $article,
            'photos' => $photos,
            'retourArticle' => $retourArticle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a photo entity.
     *
     * @Route("/{id}", name="backend_photo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Photo $photo)
    {
        $form = $this->createDeleteForm($photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush();
        }

        return $this->redirectToRoute('backend_photo_index');
    }

    /**
     * Creates a form to delete a photo entity.
     *
     * @param Photo $photo The photo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Photo $photo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_photo_delete', array('id' => $photo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
