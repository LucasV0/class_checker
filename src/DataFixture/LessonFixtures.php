<?php

namespace App\DataFixture;

use App\Entity\Absence;
use App\Entity\Justify;
use App\Entity\Lesson;
use App\Entity\Student;
use App\Entity\ToHave;
use App\Entity\User;
use App\Entity\Period;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use phpDocumentor\Reflection\DocBlock\Tags\author;


/**
 * @author Baptiste  Caron
 * methode permet de rentrer de fausses données au sein de la BDD
 */
class LessonFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        $period=[];
        $justifys = [];
        $toHaves = [];
        $users = [];
        $students = [];
        $cours = [];
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

        for ($i = 1; $i <= 200; $i++) {
            $student = new Student();
            $student
                ->setName($faker->lastName)
                ->setSurname($faker->firstName)
                ->setEmail($faker->email)
                ->setPhone($faker->phoneNumber)
                ->setBirthday($faker->dateTime)
                ->setGender(random_int(0,1) === 1 ? 'Homme' : 'Femme')
                ->setLevel($faker->word);
            $students[$i] = $student;
            $manager->persist($student);
        }
        for ($i = 1; $i <= 2; $i++){
            $period[$i] = new Period();
            $period[$i] ->setPeriodStart(date_create($faker->date(random_int(0,1) === 1 ? '01-09-2022' : '01-09-2023')))
                ->setPeriodEnd((date_create($faker->date((random_int(0,1) === 1 ? '31-08-2023' : '31-08-2024')))))
                ->setSession(random_int(0,1) === 1 ? '2022/2023' : '2023/2024')
            ;
            $manager->persist($period[$i]);
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
                ->setTeacher($users[random_int(1, count($users) )])
                ->setPeriod($period[random_int(1 , count($period) )]);

            $manager->persist($cours[$i]);
        }



        for ($i = 1; $i <= count($students); $i++) {
            $toHave = new ToHave();
            $toHave->setLessons($cours[random_int(1, count($cours))])
                    ->setStudents($students[$i]);
            $toHaves[$i]= $toHave;
            $manager->persist($toHave);
        }

        for ($i = 0; $i <3; $i++){
            $justify = new Justify();
            $justify->setStatus($i)
                    ->setDescription($faker->word);
            $justifys[$i] = $justify;
            $manager->persist($justify);
        }

        for ($i = 1; $i <= count($students); $i++) {
            $absence = new Absence();
            $toHave = $toHaves[random_int(1,count($toHaves))];
            $absence->setLessons($toHave->getLessons())
                    ->setDateJustify(date_create('now'))
                    ->setStudents($toHave->getStudents())
                    ->setJustify($justifys[random_int(0,2)]);

            $manager->persist($absence);
        }

        $manager->flush();
    }
}