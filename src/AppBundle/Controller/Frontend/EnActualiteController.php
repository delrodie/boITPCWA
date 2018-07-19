<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("en/news")
 */
class EnActualiteController extends Controller
{
    /**
     * @Route("/", name="english_news")
     */
    public function indexAction()
    {
        $actualites = $this->actualiteRepository()->findBy(array('statut'=>1), array('id'=>'DESC'));
        
        return $this->render('english/actualites.html.twig',[
            'actualites'    => $actualites,
        ]);
    }

    /**
     * @Route("/{slug}", name="english_new_article")
     */
    public function articleAction($slug)
    {
        $actualite = $this->actualiteRepository()->findOneBy(array('slug'=> $slug));
        $photo = $this->getDoctrine()->getManager()
                    ->getRepository('AppBundle:Photo')
                    ->findOneBy(array('article'=>$actualite->getId()));

        return $this->render('english/actualite_article.html.twig',[
            'actualite'   => $actualite,
            'photo'   => $photo,
        ]);
    }

    public function actualiteRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:EnArticle');
    }
}