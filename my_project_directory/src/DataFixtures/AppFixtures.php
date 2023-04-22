<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\User;
use DateTimeInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    
        public function load(ObjectManager $manager)
        {
            $faker = Faker\Factory::create('fr_FR');
    // on crée 4 auteurs avec noms et prénoms "aléatoires" en français
            

            for ($i = 0; $i < 5; $i++) {
                $auteurs = new User();
                $auteurs->setEmail($faker->email);
                $auteurs->setPseudo($faker->firstName);
                $auteurs->setPassword($faker->password(6,20));

                $manager->persist($auteurs);
            
            
          

         for ($j = 0; $j <random_int(1,3); $j++) {
            
                 $livres = new Message();
                 $livres->setDate(\DateTime::createFromFormat('d-m-Y H:i',date('d-m-Y H:i')));
                 $livres->setContenu($faker->realText(200));
                 $livres->setUser($auteurs);
                 
    
                 $manager->persist($livres);
             }

            }
            $manager->flush();
    }
}
