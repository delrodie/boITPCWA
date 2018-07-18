<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("fr/presentation")
 */
class FrPresentationController extends Controller
{
    /**
     * Liste des type de presentation
     * 
     * @Route("/", name="francais_presentation")
     */
    public function indexAction()
    {
        $types = $this->getDoctrine()->getManager()
                     ->getRepository('AppBundle:FrType')
                     ->findBy(array('statut'=>1))
        ;

        return $this->render('francais/presentation_menu.html.twig',[
            'types'=> $types,
        ]);
    }

    /**
     * @Route("/{type}", name="francais_presentation_article")
     */
    public function articleAction($type)
    {
        $presentation = $this->presentationRepository()->findPresentationByType($type); 

        if (!$presentation) {
            return $this->render('francais/page_maintenance.html.twig');
        }
        
        return $this->render('francais/presentation_article.html.twig',[
            'presentation'    => $presentation,
        ]);
    }

    public function presentationRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:FrPresentation');
    }
}