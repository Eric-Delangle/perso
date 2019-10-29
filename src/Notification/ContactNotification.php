<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ContactNotification 
{
 /**
     * @var \Swift Mailer
     */
    private $mailer;
    
    /**
    * @var Environment
    */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer) {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    /**
     * @Route("/", name="home")
     */
    public function notify() {
      
        $message = (new \Swift_Message())
            ->setFrom('copeauxdecouleurs@gmail.com')
            ->setTo('polvu@hotmail.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody(
                $this->renderer->render(
                    "emails/contact.html.twig"),
                'text/html'
            )
    
        ;
    
        $this->mailer->send($message);
    
        return $this->render('home/index.html.twig');
    }
    
}