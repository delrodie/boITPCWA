<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $locale = $request->getLocale();
        if ($locale === "fr"){
            return $this->redirectToRoute('francais_index');
        }else{
            return $this->redirectToroute('english_index');
        }
    }

    /**
     * @Route("/backend/", name="backend")
     */
    public function backendAction()
    {
        return $this->render('default/dashboard.html.twig');
    }

    /**
     * Rsume presentation pour le footer
     * 
     * @Route("/presentation/itpcwa", name="francais_presentation_footer")
     */
    public function presentationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $presentations = $em->getRepository('AppBundle:FrPresentation')->findPresentation('somme', 1, 0);
        return $this->render('English/footer_presentation.html.twig',[
            'presentations'  => $presentations,
        ]);
    }
}
