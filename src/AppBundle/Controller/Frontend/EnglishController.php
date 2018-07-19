<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Base controller.
 *
 * @Route("en")
 */
class EnglishController extends Controller
{
    /**
     * @Route("/", name="english_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sliderRepository = $em->getRepository('AppBundle:EnSlider');
        $presentationRepository = $em->getRepository('AppBundle:EnPresentation');
        $actualiteRepository = $em->getRepository('AppBundle:EnArticle');
        $campagneRepository = $em->getRepository('AppBundle:EnCampaign');
        $galerieRepository = $em->getRepository('AppBundle:Photo');
        $partenaireRepository = $em->getRepository('AppBundle:Partenaire');

        $sliders = $sliderRepository->findBy(array('statut'=>1), array('id'=>'DESC'));
        $presentation = $presentationRepository->findPresentation('our', 1, 0); //dump($presentation);die();
        $axes = $presentationRepository->findPresentation('axis', 1, 0);
        $zones = $presentationRepository->findPresentation('area', 1, 0);
        $actualites = $actualiteRepository->findBy(array('statut'=>1), array('id'=>'DESC'), 3,0);
        $campagnes = $campagneRepository->findBy(array('statut'=>1), array('id'=>'DESC'), 1,0);
        $photos = $galerieRepository->findPhoto(8, 0); //dump($photos);die();
        $partenaires = $partenaireRepository->findBy(array('statut'=>1));

        return $this->render('default/en_index.html.twig',[
            'sliders'   => $sliders,
            'presentation'   => $presentation,
            'axes'   => $axes,
            'zones'   => $zones,
            'actualites'   => $actualites,
            'campagnes'   => $campagnes,
            'photos'   => $photos,
            'partenaires'   => $partenaires,
        ]);   
    }

    /**
     * Menu droit de la page secondaire
     * 
     * @Route("/menu-droit", name="english_menu_droit")
     */
    public function menu()
    {
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('AppBundle:EnResource')->findBy(array('statut'=>1), array('id'=>'DESC'),1,0);
        return $this->render('english/menu.html.twig',[
            'publications'  => $publications,
        ]);
    }

    /**
     * Rsume presentation pour le footer
     * 
     * @Route("/prsentation/itpcwa", name="english_presentation_footer")
     */
    public function presentationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $presentations = $em->getRepository('AppBundle:EnPresentation')->findPresentation('our', 1, 0);
        return $this->render('english/footer_presentation.html.twig',[
            'presentations'  => $presentations,
        ]);
    }
}
