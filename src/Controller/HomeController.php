<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
    * @Route("/", name="home")
    */
    public function index(Request $request, ContactNotification $notification)
    {
        $form = $this->createForm(ContactType::class);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView()
        ]);
        
        $contact = new Contact();   
        dd($contact);
        dump($notification);

        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
          
            
            $notification->notify($contact);
     
            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('home');
           
        }
    }

    
}
    
   


