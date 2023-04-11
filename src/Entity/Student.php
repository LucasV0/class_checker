<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]

    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]

    private ?string $surname = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]

    private ?string $phone = null;

    /**
     * @var string|null
     *
     */
    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    /**
     * @var string|null

     */
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var string|null
     *
     */
    #[ORM\Column(length: 255)]
    private ?string $level = null;

    /**
     * @var \DateTimeInterface|null
     *
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;


    #[ORM\OneToMany(mappedBy: 'students', targetEntity: Absence::class, orphanRemoval: true)]
    private Collection $absences;


    #[ORM\OneToMany(mappedBy: 'students', targetEntity: ToHave::class, orphanRemoval: true)]
    private Collection $toHave;

    public function __construct()
    {
        $this->toHaves = new ArrayCollection();
        $this->toHave = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAbsence(): ?Absence
    {
        return $this->absence;
    }

    public function setAbsence(?Absence $absence): self
    {
        $this->absence = $absence;

        return $this;
    }

    /**
     * @return Collection<int, Absence>
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): self
    {
        if (!$this->absences->contains($absence)) {
            $this->absences->add($absence);
            $absence->setStudents($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): self
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getStudents() === $this) {
                $absence->setStudents(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, ToHave>
     */
    public function getToHave(): Collection
    {
        return $this->toHave;
    }

    public function removeToHave(ToHave $toHave): self
    {
        if ($this->toHave->removeElement($toHave)) {
            if ($toHave->getStudents() === $this) {
                $toHave->setStudents(null);
            }
        }

        return $this;
    }
}
