<?php

namespace App\Entity;

use App\Repository\JustifyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JustifyRepository::class)]
class Justify
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\OneToOne(mappedBy: 'justify', cascade: ['persist', 'remove'])]
    private ?Absence $absence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAbsence(): ?Absence
    {
        return $this->absence;
    }

    public function setAbsence(Absence $absence): self
    {
        // set the owning side of the relation if necessary
        if ($absence->getJustify() !== $this) {
            $absence->setJustify($this);
        }

        $this->absence = $absence;

        return $this;
    }
}
