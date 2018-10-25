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
     * Liste des job
     * 
     * @Route("/", name="francais_jobs")
     */
    public function indexAction()
    {
        $jobs = $this->jobRepository()->findAll();

        if (!$jobs) {return $this->render('francais/page_maintenance.html.twig');}

        return $this->render('francais/jobs_list.html.twig',[
            'jobs' => $jobs
        ]);
    }

    /**
     * @Route("/{slug}", name="francais_jobs_show")
     */
    public function showAction($slug)
    {
        $job = $this->jobRepository()->findOneBy(array('slug'=>$slug));

        if (!$job){return $this->render('francais/page_maintenance.html.twig'); }

        return $this->render('francais/job_details.html.twig',[
            'job' => $job
        ]);
    }

    public function jobRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:FrJob');
    }
}