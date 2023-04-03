<?php

namespace App\DataFixtures;

use App\Entity\Student;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 15; $i++) {
            $student = new Student();
            $student
                ->setName($faker->lastName)
                ->setSurname($faker->firstName)
                ->setEmail($faker->email)
                ->setPhone($faker->phoneNumber)
                ->setBirthday($faker->dateTime)
                ->setGender(random_int(0,1) === 1 ? 'Homme' : 'Femme')
                ->setLevel($faker->word);
            $manager->persist($student);
        }

        $manager->flush();
    }
}
