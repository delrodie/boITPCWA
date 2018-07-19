<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("en/gallery")
 */
class EnGalleryController extends Controller
{
    /**
     * Liste des type de presentation
     * 
     * @Route("/", name="english_gallery")
     */
    public function indexAction()
    {
        $albums = $this->photoRepository()->findGalerie();

        return $this->render('english/gallery.html.twig',[
            'albums'=> $albums,
        ]);
    }

    /**
     * @Route("/{slug}", name="english_gallery_photo")
     */
    public function articleAction($slug)
    {
        $photos = $this->photoRepository()->findListPhoto($slug); 
        $album = $this->getDoctrine()->getManager()
                      ->getRepository('AppBundle:FrArticle')
                      ->findOneBy(array('slug'=>$slug))
        ;

        if (!$photos) {
            return $this->render('english/page_maintenance.html.twig');
        }
        
        return $this->render('francais/galerie_photo.html.twig',[
            'photos'    => $photos,
            'album'    => $album,
        ]);
    }

    public function photoRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:Photo');
    }
}