<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Swift;

class HomeController extends AbstractController
{
    /**
     * @var \Swift Mailer
     */
    private $mailer;
    

    public function __construct(\Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }


    /**
    * @Route("/", name="home")
    */
    public function index(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        
    
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $message = (new \Swift_Message($contact))
            ->setFrom('info@ericdelangle.fr')
            ->setTo('polvu@hotmail.fr')
            ->setSubject($contact->getSubject())
            ->setReplyTo($contact->getEmail())
            ->setBody($contact->getMessage(),'text/html')
        ;
   
        $this->addFlash('success', 'Votre message a bien été envoyé !');
        $this->mailer->send($message);
            
            return $this->redirectToRoute('home');
           
        }
 
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView()
        ]);   
        
        }
      

    
}
    
   


