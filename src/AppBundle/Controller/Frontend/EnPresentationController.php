<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("en/presentation")
 */
class EnPresentationController extends Controller
{
    /**
     * Liste des type de presentation
     * 
     * @Route("/", name="english_presentation")
     */
    public function indexAction()
    {
        $types = $this->getDoctrine()->getManager()
                     ->getRepository('AppBundle:EnType')
                     ->findBy(array('statut'=>1))
        ;

        return $this->render('english/presentation_menu.html.twig',[
            'types'=> $types,
        ]);
    }

    /**
     * @Route("/{type}", name="english_presentation_article")
     */
    public function articleAction($type)
    {
        $presentation = $this->presentationRepository()->findPresentationByType($type); 

        if (!$presentation) {
            return $this->render('english/page_maintenance.html.twig');
        }
        
        return $this->render('english/presentation_article.html.twig',[
            'presentation'    => $presentation,
        ]);
    }

    public function presentationRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:EnPresentation');
    }
}