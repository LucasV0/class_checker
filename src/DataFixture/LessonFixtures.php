<?php

namespace App\DataFixture;

use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class LessonFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 10; $i++) {
            $cours[$i] = new Lesson();
            $cours[$i]->setLabel("Lesson [$i]")
                ->setNumberMaxOfStudents($faker->numberBetween(3,30))
                ->setTimeStart(date_create($faker->date()))
                ->setTimeEnd(date_create($faker->date()))
                ->setHoursStart(date_create($faker->time("H:i")))
                ->setHoursEnd((date_create($faker->time("H:i"))))
                ->setDay($faker->dayOfWeek());
            $manager->persist($cours[$i]);
        }
        $manager->flush();
    }
}