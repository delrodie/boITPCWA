<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("en/contact")
 */
class EnContactController extends Controller
{
    /**
     * formulaire d'envoi de mail
     * 
     * @Route("/", name="english_contact")
     */
    public function indexAction()
    {
        //$albums = $this->photoRepository()->findGalerie();

        return $this->render('english/contact.html.twig');
    }

    /**
     * Envoie de mail 
     * 
     * @Route("/envoie-de-mail", name="english_contact_mail")
     * @Method({"GET", "POST"})
     */
    public function mailAction(Request $request, \Swift_Mailer $mailer)
    {
        $nom = $request->get('name');
        $email = $request->get('email');
        $location = $request->get('location');
        $observation = $request->get('message'); //dump($message);die();

        $captcha = $request->get('g-recaptcha-response'); 

        if ($captcha) {
            if ($this->verificationCaptcha($captcha)) {
                $message = (new \Swift_Message('Envoi de mail depuis le site internet'))
                    ->setFrom(['noreply@itpcwa.org' => 'ITPC WEST AFRICA'])
                    //->setTo($partenaire)
                    ->setTo(['infos@itpcwa.org', 'atraore@itpcwa.org'])
                    //->setTo(['delrodieamoikon@gmail.com', 'delrodieamoikon@outlook.fr'])
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
            } else {
                $this->addFlash('erreur', 'ne sommes desolé votre message n\'a pas pu être envoyé');
                return $this->redirectToRoute('english_contact');
            }            
        } else {
            $this->addFlash('erreur', 'Oups!! nous n\'avons pas pu verifier que vous n\'etes pas un robot!');
            return $this->redirectToRoute('english_contact');
        }
                

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

          return $this->redirectToRoute('english_contact');
    }

    /**
     * Verifcation du captcha
     */
    public function verificationCaptcha($recaptcha)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                "secret"=>"6LeEB2UUAAAAALNT3B_52iX8U5DLI8jtJhxxGEa9","response"=>$recaptcha));
            $response = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($response);     
        
        return $data->success;
    }
}