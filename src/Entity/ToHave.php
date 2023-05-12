<?php

namespace App\Entity;

use App\Repository\ToHaveRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ToHaveRepository::class)]
#[UniqueEntity(fields: ['students'], message: 'Un ou plusieurs élèves sont déjà attribué a ce cour')]
class ToHave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'toHave')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $students = null;

    #[ORM\ManyToOne(inversedBy: 'toHave')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lesson $Lessons = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudents(): ?Student
    {
        return $this->students;
    }

    public function setStudents(?Student $students): self
    {
        $this->students = $students;

        return $this;
    }

    public function getLessons(): ?Lesson
    {
        return $this->Lessons;
    }

    public function setLessons(?Lesson $Lessons): self
    {
        $this->Lessons = $Lessons;

        return $this;
    }

}
