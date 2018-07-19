<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("en/resources")
 */
class EnRessourcesController extends Controller
{
    /**
     * Liste des ressources
     * 
     * @Route("/", name="english_ressources")
     */
    public function indexAction()
    {
        $ressources = $this->ressourceRepository()->findBy(array('statut'=>1),array('id'=>'DESC'));

        if (!$ressources) {
            return $this->render('english/page_maintenance.html.twig');
        }

        return $this->render('english/resources.html.twig',[
            'ressources'=> $ressources,
        ]);
    }

    public function ressourceRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:EnResource');
    }
}