<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("en/campaign")
 */
class EnCampagneController extends Controller
{
    /**
     * Liste des type de presentation
     * 
     * @Route("/", name="english_campagne")
     */
    public function indexAction()
    {
        $menus = $this->campagneRepository()->findBy(array('statut'=>1),array('id'=>'DESC'),1,0)
        ;

        return $this->render('english/campagne_menu.html.twig',[
            'menus'=> $menus,
        ]);
    }

    /**
     * @Route("/{slug}", name="english_campagne_article")
     */
    public function articleAction($slug)
    {
        $campagne = $this->campagneRepository()->findOneBy(array('slug'=>$slug)); 

        if (!$campagne) {
            return $this->render('english/page_maintenance.html.twig');
        }

        $campagnefrancais = $this->getDoctrine()->getManager()
                                 ->getRepository('AppBundle:FrCampagne')
                                 ->findBy(array('statut'=>1),array('id'=>'DESC'),1,0)
        ;
        
        return $this->render('english/campagne_article.html.twig',[
            'campagne'    => $campagne,
            'campagnefrancais'    => $campagnefrancais,
        ]);
    }

    public function campagneRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:EnCampaign');
    }
}