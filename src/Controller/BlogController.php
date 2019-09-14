<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Reunion;
use App\Form\ParticipantType;
use App\Form\ReunionType;
use App\Repository\ParticipantRepository;
use App\Repository\ReunionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    //pour afficher la liste de toutes les reunions
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ReunionRepository $repo)
    {
        $reunions = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'reunions' => $reunions
        ]);
    }


    //Pour acceder à l'acceuil de mon application
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }


    /**
     * @Route("/admin/new_participant", name="blog_create_participant")
     * @Route("/admin/{id}/editer/participant", name="blog_editer_participant")
     */
    public function formP(Participant $participant = null,Request $request, ObjectManager $manager)
    {
        if(!$participant){

            $participant = new Participant();
        }
        
       // $form = $this->createFormBuilder($participant)
       //              ->add('nom')
       //              ->add('prenom')
       //              ->add('poste')
       //              ->add('email')
       //              ->add('telephone')
       //              ->getForm();

       $form = $this->createForm(ParticipantType::class, $participant);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$participant->getId()){

                $participant->setCreatedAt(new \DateTime());
            }

            $manager->persist($participant);
            $manager->flush();

            return $this->redirectToRoute('look_participant', ['id' => $participant->getId()]);
        }

        return $this->render('blog/create_participant.html.twig', [
            'formParticipant' => $form->createView(),
            'editMode' => $participant->getId() !== null
        ]);
    }


    //pour afficher la liste des participants
    /**
     * @Route("/admin/liste_participants", name="blog_participant")
     */
    public function show2(ParticipantRepository $repo){
        
       // $repo = $this->getDoctrine()->getRepository(Participant::class);

        $participants = $repo->findAll();

        return $this->render('blog/participants.html.twig', [
            'participants' => $participants
        ]);
    }


    //pour voir le participant en particulier
    /**
     * @Route("/admin/participant/{id}", name="look_participant")
     */
    public function look(Participant $participant){

        //$repo = $this->getDoctrine()->getRepository(Participant::class);
       // $participant = $repo->find($id);
        return $this->render('blog/participant.html.twig', [
            'participant' => $participant
        ]);
    }

    //Pour la creation des reunions
    /**
     * @Route("/admin/planifier", name="blog_create_reunion")
     * @Route("/admin/blog/{id}/editer/reunion", name="blog_editer_reunion")
     */
    public function form(Reunion $reunion = null, Request $request, ObjectManager $manager)
    {
        if(!$reunion){
            $reunion = new Reunion();
        }
        
       // $form = $this->createFormBuilder($reunion)
       //              ->add('title')
       //              ->add('theme')
       //              ->add('type')
       //              ->add('salle')
       //              ->add('details')
       //              ->add('date')
       //              ->add('heureDebut')
       //              ->add('heureFin') 
       //              ->getForm(); 
       
       $form = $this->createForm(ReunionType::class, $reunion);
        
        $form->handleRequest($request);

        if($form-> isSubmitted() && $form->isValid()){
            if(!$reunion->getId()){

                $reunion->setCreatedAt(new \DateTime());
            }

            $manager->persist($reunion);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $reunion->getId()]);
        }

        return $this->render('blog/create_reunion.html.twig', [
            'formReunion' => $form->createView(),
            'editMode' => $reunion->getId() !== null
        ]);
    }

    

    //Pour afficher un reunion en particulier
    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Reunion $reunion)
    {

        //$reunion = $repo->find($id); l'extentiation de la classe de façon manuelle

        return $this->render('blog/show.html.twig', [
            'reunion' => $reunion 
        ]);
    }
}
