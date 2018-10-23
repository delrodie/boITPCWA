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
        if ($type === 'team') {
            $typeId = $this->getDoctrine()->getManager()
                            ->getRepository('AppBundle:EnType')->findOneBy(array('slug'=>$type))->getId()
            ;
            $equipes = $this->presentationRepository()->findBy(array('type'=> $typeId)); //dump($equipes);die();

            if (!$equipes) {
                return $this->render('english/page_maintenance.html.twig');
            }
            return $this->render('english/presentation_equipe.html.twig',[
                'equipes'   => $equipes,
            ]);
        }

        if ($type === 'organ'){
            $typeId = $this->getDoctrine()->getManager()
                            ->getRepository('AppBundle:EnType')->findOneBy(array('slug'=>$type))->getId();

            $organs = $this->presentationRepository()->findBy(array('type'=>$typeId, 'statut'=>1));

            if (!$organs){
                return $this->render('english/page_maintenance.html.twig');
            }
            return $this->render('english/presentation_organ.html.twig',[
                'organs' => $organs
            ]);
        }

        $presentation = $this->presentationRepository()->findPresentationByType($type); 

        if (!$presentation) {
            return $this->render('english/page_maintenance.html.twig');
        }
        
        return $this->render('english/presentation_article.html.twig',[
            'presentation'    => $presentation,
        ]);
    }

    /**
     * @route("/biographie/{slug}", name="english_presentation_equipe")
     */
    public function biographieAction($slug)
    {
        $presentation = $this->presentationRepository()->findOneBy(array('slug'=>$slug));

        if (!$presentation) {
            return $this->render('english/page_maintenance.html.twig');
        }

        
        return $this->render('english/presentation_article.html.twig',[
            'presentation'    => $presentation,
        ]);
    }

    /**
     * @route("/organ/{slug}/", name="english_presentation_organ")
     */
    public function organAction($slug)
    {
        $presentation = $this->presentationRepository()->findOneBy(array('slug'=>$slug));
        if (!$presentation){
            return $this->render('english/page_maintenance.html.twig');
        }

        return $this->render('english/presentation_article.html.twig',[
            'presentation' => $presentation
        ]);
    }

    public function presentationRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:EnPresentation');
    }
}