<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    //pour l'inscription sur l'application
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager,
    UserPasswordEncoderInterface $encoder) {
        
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            // le hash c'est pourvoir crypter le mot de passe
           $hash = $encoder->encodePassword($user, $user->getPassword());

           $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_connexion');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);

    }

    //Pour la connexion
    /**
     * @Route("/connexion", name="security_connexion")
     */
    public function connexion(){
        return $this->render('security/connexion.html.twig');
    }

    //Pour la déconnexion
    /**
     * @Route("/deconnexion", name="security_deconnexion")
     */
    public function deconnexion(){}
}
