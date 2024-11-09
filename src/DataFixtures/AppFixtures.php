<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use App\Entity\Cinemas;
use App\Entity\Films;
use App\Entity\Reservations;
use App\Entity\Salles;
use App\Entity\Seance;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');



        for ($i = 0; $i < 10; $i++) {
            $cinema = new Cinemas();
            $cinema->setNom ($faker->company);
            $cinema->setVille ($faker->city ());
            $manager->persist ($cinema);
        }
        for ($i = 0; $i < 10; $i++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_utilisateur']);
            $user->setPassword($faker->password);
            $manager->persist($user);

        }


        $manager->flush();
    }
}
