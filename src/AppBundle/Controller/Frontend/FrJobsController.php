<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("fr/jobs")
 */
class FrJobsController extends Controller
{
    /**
     * Liste des ressources
     * 
     * @Route("/", name="francais_jobs")
     */
    public function indexAction()
    {
        return $this->render('francais/page_maintenance.html.twig');
    }

    public function ressourceRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:FrRessource');
    }
}