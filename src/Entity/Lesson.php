<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


/**
 * @author Baptiste Caron
 *
 */
#[ORM\Entity(repositoryClass: LessonRepository::class)]

class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     *
     */
    #[ORM\Column(length: 255)]
    private ?string $Label = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $Number_Max_Of_Students = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Time_Start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Time_End = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Hours_Start = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Hours_End = null;

    #[ORM\Column(length: 255)]
    private ?string $Day = null;

    #[ORM\ManyToOne(inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $teacher = null;



    #[ORM\OneToMany(mappedBy: 'Lessons', targetEntity: ToHave::class, orphanRemoval: false)]
    private Collection $toHave;

    #[ORM\ManyToOne(inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Period $Period = null;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: Session::class, orphanRemoval: false)]
    private Collection $sessions;



    public function __construct()
    {
        $this->toHave = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->Label;
    }

    public function setLabel(string $Label): self
    {
        $this->Label = $Label;

        return $this;
    }

    public function getNumberMaxOfStudents(): ?int
    {
        return $this->Number_Max_Of_Students;
    }

    public function setNumberMaxOfStudents(int $Number_Max_Of_Students): self
    {
        $this->Number_Max_Of_Students = $Number_Max_Of_Students;

        return $this;
    }

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->Time_Start;
    }

    public function setTimeStart(\DateTimeInterface $Time_Start): self
    {
        $this->Time_Start = $Time_Start;

        return $this;
    }

    public function getTimeEnd(): ?\DateTimeInterface
    {
        return $this->Time_End;
    }

    public function setTimeEnd(\DateTimeInterface $Time_End): self
    {
        $this->Time_End = $Time_End;

        return $this;
    }

    public function getHoursStart(): ?\DateTimeInterface
    {
        return $this->Hours_Start;
    }

    public function setHoursStart(\DateTimeInterface $Hours_Start): self
    {
        $this->Hours_Start = $Hours_Start;

        return $this;
    }

    public function getHoursEnd(): ?\DateTimeInterface
    {
        return $this->Hours_End;
    }

    public function setHoursEnd(\DateTimeInterface $Hours_End): self
    {
        $this->Hours_End = $Hours_End;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->Day;
    }

    public function setDay(string $Day): self
    {
        $this->Day = $Day;

        return $this;
    }

    public function getTeacher(): ?User
    {
        return $this->teacher;
    }

    public function setTeacher(?User $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function __toString(){
        return $this->Label ?? '';
    }

    /**
     * @return Collection<int, ToHave>
     */
    public function getToHave(): Collection
    {
        return $this->toHave;
    }

    public function addToHave(ToHave $toHave): self
    {
        if (!$this->toHave->contains($toHave)) {
            $this->toHave->add($toHave);
            $toHave->setLessons($this);
        }

        return $this;
    }

    public function removeToHave(ToHave $toHave): self
    {
        if ($this->toHave->removeElement($toHave)) {
            if ($toHave->getLessons() === $this) {
                $toHave->setLessons(null);
            }
        }

        return $this;
    }

    public function getPeriod(): ?Period
    {
        return $this->Period;
    }

    public function setPeriod(?Period $Period): self
    {
        $this->Period = $Period;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setLesson($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getLesson() === $this) {
                $session->setLesson(null);
            }
        }

        return $this;
    }

}