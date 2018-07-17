<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Base controller.
 *
 * @Route("fr")
 */
class FrancaisController extends Controller
{
    /**
     * @Route("/", name="francais_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sliderRepository = $em->getRepository('AppBundle:FrSlider');
        $presentationRepository = $em->getRepository('AppBundle:FrPresentation');
        $actualiteRepository = $em->getRepository('AppBundle:FrArticle');
        $campagneRepository = $em->getRepository('AppBundle:FrCampagne');
        $galerieRepository = $em->getRepository('AppBundle:Photo');
        $partenaireRepository = $em->getRepository('AppBundle:Partenaire');

        $sliders = $sliderRepository->findBy(array('statut'=>1), array('id'=>'DESC'));
        $presentation = $presentationRepository->findPresentation('somme', 1, 0); //dump($presentation);die();
        $axes = $presentationRepository->findPresentation('axe', 1, 0);
        $zones = $presentationRepository->findPresentation('zone', 1, 0);
        $actualites = $actualiteRepository->findBy(array('statut'=>1), array('id'=>'DESC'), 3,0);
        $campagnes = $campagneRepository->findBy(array('statut'=>1), array('id'=>'DESC'), 1,0);
        $photos = $galerieRepository->findPhoto(8, 0); //dump($photos);die();
        $partenaires = $partenaireRepository->findBy(array('statut'=>1));

        return $this->render('default/index.html.twig',[
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
}
