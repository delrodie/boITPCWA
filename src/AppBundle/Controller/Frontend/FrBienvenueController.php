<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("fr/bienvenue")
 */
class FrBienvenueController extends Controller
{

    /**
     * @Route("/{slug}", name="francais_bienvenue_article")
     */
    public function articleAction($slug)
    {
        $bienvenue = $this->bienvenueRepository()->findOneBy(array('slug'=>$slug));

        if (!$bienvenue) {
            return $this->render('francais/page_maintenance.html.twig');
        }

        $welcomeAnglais = $this->getDoctrine()->getManager()
                                 ->getRepository('AppBundle:EnWelcome')
                                 ->findBy(array('statut'=>1),array('id'=>'DESC'),1,0)
        ;
        
        return $this->render('francais/bienvenue_article.html.twig',[
            'bienvenue'    => $bienvenue,
            'welcomeAnglais'    => $welcomeAnglais,
        ]);
    }

    public function  bienvenueRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:FrBienvenue');
    }
}