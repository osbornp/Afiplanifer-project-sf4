<?php

namespace App\DataFixtures;

use App\Entity\Reunion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ReunionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //pour gener 10 fausses donnees dans ma base
        for($i = 1; $i <= 5; $i++){
            $reunion = new Reunion();
            $reunion->setTitle("Titre de la reunion n°$i")
                    ->setTheme("Theme de la reunion n°$i")
                    ->setType("Type de la reunion n°$i")
                    ->setCreatedAt(new \DateTime())
                    ->setSalle("Sale de la reunion n°$i")
                    ->setDetails("Details de la reunion n°$i")
                    ->setDate("Date de la tenu de la reunion n°$i")
                    ->setHeureDebut("L'heure de la tenu de la reunion n°$i")
                    ->setHeureFin("L'heure de la tenu de la reunion n°$i");
            
             $manager->persist($reunion);
        }

        $manager->flush();
    }
}
