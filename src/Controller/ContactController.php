<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
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
       //$this->contact = new Contact();
    }

    /**
     * @Route("/", name="home")
     */
    public function sendMail() {
      
        $message = (new \Swift_Message())
            ->setFrom('infos@avenuedesartistes.com')
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
