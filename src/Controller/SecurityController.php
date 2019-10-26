<?php

namespace App\Controller;

use App\Entity\UserDev;
use App\Entity\Category;
use ReCaptcha\ReCaptcha;
use App\Form\UserDevType;
//use App\Controller\UserDevType;
use App\Entity\AdminController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends Controller
{
    /**
     * @Route("/inscription_dev", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $userDev = new UserDev();
        $form = $this->createForm(UserDevType::class, $userDev);
        $form->handleRequest($request);
        
        /* captcha */
        /*
        $recaptcha = new ReCaptcha('');
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
  
        if (!$resp->isSuccess()) {
         // $this->addFlash('N\'oubliez pas de cocher la case "Je ne suis pas un robot"');
        } else {
       */
        if($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($userDev, $userDev->getPassword());
            $userDev->setPassword($hash);
            $userDev->getCategories(new Category());
            $userDev->setRegisteredAt(new \DateTime());
           // $userDev->setNiveau(1);
            $manager->persist($userDev);
            $manager->flush();
            $this->addFlash('success', 'Votre compte a bien été créé');
            return $this->redirectToRoute('security_login');
           
        }
     // }
        
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
}

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
  {
    // Si le visiteur est déjà identifié, on le redirige vers l'accueil
    if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      return $this->redirectToRoute('member');
    }

    // Le service authentication_utils permet de récupérer le nom d'utilisateur
    // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
    // (mauvais mot de passe par exemple)
    $authenticationUtils = $this->get('security.authentication_utils');

    return $this->render('security/login.html.twig', array(
      'last_email' => $authenticationUtils->getLastEmail(),
      'error'         => $authenticationUtils->getLastAuthenticationError(),
    ));
  }

     /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {
        
    }
}
