<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbsenceRepository::class)]
class Absence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $Justification = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_justify = null;

    #[ORM\OneToMany(mappedBy: 'absence', targetEntity: Student::class)]
    private Collection $Student;

    #[ORM\Column]
    private ?int $Lesson = null;

    public function __construct()
    {
        $this->Student = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Student>
     */
    public function getStudent(): Collection
    {
        return $this->Student;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->Student->contains($student)) {
            $this->Student->add($student);
            $student->setAbsence($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->Student->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getAbsence() === $this) {
                $student->setAbsence(null);
            }
        }

        return $this;
    }

    public function getLesson(): ?int
    {
        return $this->Lesson;
    }

    public function setLesson(int $Lesson): self
    {
        $this->Lesson = $Lesson;

        return $this;
    }
}
