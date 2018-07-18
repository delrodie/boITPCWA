<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("fr/campagne")
 */
class FrCampagneController extends Controller
{
    /**
     * Liste des type de presentation
     * 
     * @Route("/", name="francais_campagne")
     */
    public function indexAction()
    {
        $menus = $this->campagneRepository()->findBy(array('statut'=>1),array('id'=>'DESC'),1,0)
        ;

        return $this->render('francais/campagne_menu.html.twig',[
            'menus'=> $menus,
        ]);
    }

    /**
     * @Route("/{slug}", name="francais_campagne_article")
     */
    public function articleAction($slug)
    {
        $campagne = $this->campagneRepository()->findOneBy(array('slug'=>$slug)); 

        if (!$campagne) {
            return $this->render('francais/page_maintenance.html.twig');
        }
        
        return $this->render('francais/campagne_article.html.twig',[
            'campagne'    => $campagne,
        ]);
    }

    public function campagneRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:FrCampagne');
    }
}