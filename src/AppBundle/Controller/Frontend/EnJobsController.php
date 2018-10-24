<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("en/jobs")
 */
class EnJobsController extends Controller
{
    /**
     * Liste des ressources
     * 
     * @Route("/", name="english_jobs")
     */
    public function indexAction()
    {
        return $this->render('english/page_maintenance.html.twig');
    }

    public function ressourceRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:EnResource');
    }
}