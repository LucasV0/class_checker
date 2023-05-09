<?php

namespace App\Entity;

use App\Repository\PeriodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Caron Baptiste
 * @entity Period
 */
#[ORM\Entity(repositoryClass: PeriodRepository::class)]
class Period
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Period_Start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Period_End = null;

    #[ORM\Column(length: 255)]
    private ?string $Session = null;

    #[ORM\OneToMany(mappedBy: 'Period', targetEntity: Lesson::class)]
    private Collection $lessons;

    #[ORM\Column]
    private ?bool $currentPeriod = false;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriodStart(): ?\DateTimeInterface
    {
        return $this->Period_Start;
    }

    public function setPeriodStart(\DateTimeInterface $Period_Start): self
    {
        $this->Period_Start = $Period_Start;

        return $this;
    }

    public function getPeriodEnd(): ?\DateTimeInterface
    {
        return $this->Period_End;
    }

    public function setPeriodEnd(\DateTimeInterface $Period_End): self
    {
        $this->Period_End = $Period_End;

        return $this;
    }

    public function getSession(): ?string
    {
        return $this->Session;
    }

    public function setSession(string $Session): self
    {
        $this->Session = $Session;

        return $this;
    }

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons->add($lesson);
            $lesson->setPeriod($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getPeriod() === $this) {
                $lesson->setPeriod(null);
            }
        }

        return $this;
    }

    public function isCurrentPeriod(): ?bool
    {
        return $this->currentPeriod;
    }

    public function setCurrentPeriod(bool $currentPeriod): self
    {
        $this->currentPeriod = $currentPeriod;

        return $this;
    }
}
