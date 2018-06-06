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
            return $this->render('default/index.html.twig');
        }else{
            return $this->render('default/index_en.html.twig');
        }
    }

    /**
     * @Route("/backend/", name="backend")
     */
    public function backendAction()
    {
        return $this->render('default/index.html.twig');
    }
}
