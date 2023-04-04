<?php

namespace App\DataFixture;

use App\Entity\Lesson;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use phpDocumentor\Reflection\DocBlock\Tags\author;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

/**
 * @author Baptiste  Caron
 * methode permet de rentrer de fausses données au sein de la BDD
 */
class LessonFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $users = [];
        for ($i = 1; $i <= 25; $i++) {
            $users[$i] = new User();
            $users[$i]->setEmail($faker->email)
                ->setPassword(hash('md5',$faker->password() ))
                ->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setRoles(['ROLE_PROF'])
                ->setTelephone($faker->phoneNumber)
                ->setDateNaissance(date_create($faker->date()))
                ->setSexe(random_int(0,1) === 1 ? 'Homme' : 'Femme');
            $manager->persist($users[$i]);
        }

        for ($i = 1; $i <= 50; $i++) {
            $cours[$i] = new Lesson();
            $cours[$i]->setLabel("Lesson [$i]")
                ->setNumberMaxOfStudents($faker->numberBetween(3,30))
                ->setTimeStart(date_create($faker->date()))
                ->setTimeEnd(date_create($faker->date()))
                ->setHoursStart(date_create($faker->time("H:i")))
                ->setHoursEnd((date_create($faker->time("H:i"))))
                ->setDay($faker->dayOfWeek())
                ->setTeacher($users[random_int(1, count($users) )]);
            $manager->persist($cours[$i]);
        }
        $manager->flush();
    }
}