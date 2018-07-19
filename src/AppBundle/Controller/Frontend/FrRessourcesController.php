<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("fr/ressources")
 */
class FrRessourcesController extends Controller
{
    /**
     * Liste des ressources
     * 
     * @Route("/", name="francais_ressources")
     */
    public function indexAction()
    {
        $ressources = $this->ressourceRepository()->findBy(array('statut'=>1),array('id'=>'DESC'));

        if (!$ressources) {
            return $this->render('francais/page_maintenance.html.twig');
        }

        return $this->render('francais/ressources.html.twig',[
            'ressources'=> $ressources,
        ]);
    }

    public function ressourceRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:FrRessource');
    }
}