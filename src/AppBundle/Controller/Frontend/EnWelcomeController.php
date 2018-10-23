<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("en/welcome")
 */
class EnWelcomeController extends Controller
{
    /**
     * @Route("/{slug}", name="english_welcome_article")
     */
    public function articleAction($slug)
    {
        $welcome = $this->welcomeRepository()->findOneBy(array('slug'=>$slug));

        if (!$welcome) {
            return $this->render('english/page_maintenance.html.twig');
        }

        $bienvenuefrancais = $this->getDoctrine()->getManager()
                                 ->getRepository('AppBundle:FrBienvenue')
                                 ->findBy(array('statut'=>1),array('id'=>'DESC'),1,0)
        ;
        
        return $this->render('english/welcome_article.html.twig',[
            'welcome'    => $welcome,
            'bienvenuefrancais'    => $bienvenuefrancais,
        ]);
    }

    public function welcomeRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:EnWelcome');
    }
}