<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Label = null;

    #[ORM\Column]
    private ?int $Students_Max_Numbers = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Time_Start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $End_Time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Time_Slot = null;

    #[ORM\Column(length: 255)]
    private ?string $Day = null;

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

    public function getStudentsMaxNumbers(): ?int
    {
        return $this->Students_Max_Numbers;
    }

    public function setStudentsMaxNumbers(int $Students_Max_Numbers): self
    {
        $this->Students_Max_Numbers = $Students_Max_Numbers;

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

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->End_Time;
    }

    public function setEndTime(\DateTimeInterface $End_Time): self
    {
        $this->End_Time = $End_Time;

        return $this;
    }

    public function getTimeSlot(): ?\DateTimeInterface
    {
        return $this->Time_Slot;
    }

    public function setTimeSlot(\DateTimeInterface $Time_Slot): self
    {
        $this->Time_Slot = $Time_Slot;

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
}
