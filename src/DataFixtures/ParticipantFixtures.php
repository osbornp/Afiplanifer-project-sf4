<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ParticipantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i<= 5; $i++){
            $participant = new Participant();
            $participant->setNom("Nom du participant n°$i")
                        ->setPrenom("Prenom du participant n°$i")
                        ->setPoste("Poste du participant n°$i")
                        ->setEmail("Email du participant n°$i")
                        ->setTelephone("Telephone du participant n°$i")
                        ->setCreatedAt(new \DateTime());
            $manager->persist($participant);
        }

        $manager->flush();
    }
}
