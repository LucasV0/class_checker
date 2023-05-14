<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AbsenceRepository::class)]
#[ORM\UniqueConstraint( name: 'clee' , fields: ['students', 'session'])]
class Absence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_justify = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $students = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Justify $justify = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateJustify(): ?\DateTimeInterface
    {
        return $this->Date_justify;
    }

    public function setDateJustify(\DateTimeInterface $Date_justify): self
    {
        $this->Date_justify = $Date_justify;

        return $this;
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

    public function getJustify(): ?Justify
    {
        return $this->justify;
    }

    public function setJustify(?Justify $justify): self
    {
        $this->justify = $justify;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

}
