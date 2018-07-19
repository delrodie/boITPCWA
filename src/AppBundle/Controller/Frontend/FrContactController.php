<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("fr/contact")
 */
class FrContactController extends Controller
{
    /**
     * formulaire d'envoi de mail
     * 
     * @Route("/", name="francais_contact")
     */
    public function indexAction()
    {
        //$albums = $this->photoRepository()->findGalerie();

        return $this->render('francais/contact.html.twig');
    }

    /**
     * Envoie de mail 
     * 
     * @Route("/envoie-de-mail", name="francais_contact_mail")
     * @Method({"GET", "POST"})
     */
    public function mailAction(Request $request, \Swift_Mailer $mailer)
    {
        $nom = $request->get('name');
        $email = $request->get('email');
        $location = $request->get('location');
        $observation = $request->get('message'); //dump($message);die();

        $message = (new \Swift_Message('Envoi de mail depuis le site internet'))
                    ->setFrom(['noreply@itpcwa.org' => 'ITPC WEST AFRICA'])
                    //->setTo($partenaire)
                    //->setTo(['infos@itpcwa.org', 'atraore@itpcwa.org'])
                    ->setTo(['delrodieamoikon@gmail.com', 'delrodieamoikon@outlook.fr'])
                    //->setBcc(['info@alloimmo.ci', 'delrodieamoikon@gmail.com'])
                    ->setBcc('delrodieamoikon@gmail.com')
                    ->setReplyTo($email)
                    ->setBody(
                        $this->renderView(
                          'francais/contact_mail.html.twig',[
                            'nom' => $nom,
                            'email' => $email,
                            'location' => $location,
                            'message' => $observation,
                          ]
                        ), 'text/html'
                      )
        ;

        if ($mailer->send($message)) {
            $this->addFlash('notice', 'Votre message a bien été envoyé !');
        } else {
            $this->addFlash('erreur', 'ne sommes desolé votre message n\'a pas pu être envoyé');
        }

        /*return $this->render('francais/contact_mail.html.twig',[
            'nom' => $nom,
            'email' => $email,
            'message' => $observation,
            'location'  => $location,
          ]);*/

          return $this->redirectToRoute('francais_contact');
    }
}