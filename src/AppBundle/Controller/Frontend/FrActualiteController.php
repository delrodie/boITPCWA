<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("fr/actualites")
 */
class FrActualiteController extends Controller
{
    /**
     * @Route("/", name="francais_actualites")
     */
    public function indexAction()
    {
        $actualites = $this->actualiteRepository()->findBy(array('statut'=>1), array('id'=>'DESC'));
        
        return $this->render('francais/actualites.html.twig',[
            'actualites'    => $actualites,
        ]);
    }

    public function actualiteRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:FrArticle');
    }
}