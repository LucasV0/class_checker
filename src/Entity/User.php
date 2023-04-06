<?php

namespace App\Entity;

use Ambta\DoctrineEncryptBundle\Configuration\Encrypted;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author LUCAS V
 */

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 350, unique: true)]
    private ?string $email = null;

    /**
     * @var string|null
     * @Encrypted
     */
    #[ORM\Column(type: 'string',length:350, nullable: true)]
   private ?string $googleAuthenticatorSecret ='';

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     * @var string|null
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var string|null
     * @Encrypted
     */
    #[ORM\Column(length: 350)]
    private ?string $nom = null;

    /**
     * @var string|null
     * @Encrypted
     */
    #[ORM\Column(length: 350)]
    private ?string $prenom = null;

    /**
     * @var string|null
     * @Encrypted
     */
    #[ORM\Column(length: 350)]
    private ?string $telephone = null;

    /**
     * @var string|null
     * @Encrypted
     */
    #[ORM\Column(length: 350)]
    private ?string $sexe = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: Lesson::class, orphanRemoval: true)]
    private Collection $lessons;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
    }

    /*
    Getters et Setters
    */

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
/*
gérer l'authentification à double facteur grace a Google Authenticator.
*/
    public function isGoogleAuthenticatorEnabled(): bool
   {
       return null !== $this->googleAuthenticatorSecret;
   }

   public function getGoogleAuthenticatorUsername(): string
   {
       return $this->email;
   }

   public function getGoogleAuthenticatorSecret(): ?string
   {
       return $this->googleAuthenticatorSecret;
   }

   public function setGoogleAuthenticatorSecret(?string $googleAuthenticatorSecret): void
   {
       $this->googleAuthenticatorSecret = $googleAuthenticatorSecret;
   }

   public function getNom(): ?string
   {
       return $this->nom;
   }

   public function setNom(string $nom): self
   {
       $this->nom = $nom;

       return $this;
   }

   public function getPrenom(): ?string
   {
       return $this->prenom;
   }

   public function setPrenom(string $prenom): self
   {
       $this->prenom = $prenom;

       return $this;
   }

   public function getTelephone(): ?string
   {
       return $this->telephone;
   }

   public function setTelephone(string $telephone): self
   {
       $this->telephone = $telephone;

       return $this;
   }

   public function getSexe(): ?string
   {
       return $this->sexe;
   }

   public function setSexe(string $sexe): self
   {
       $this->sexe = $sexe;

       return $this;
   }

   public function getDateNaissance(): ?\DateTimeInterface
   {
       return $this->date_naissance;
   }

   public function setDateNaissance(\DateTimeInterface $date_naissance): self
   {
       $this->date_naissance = $date_naissance;

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
           $lesson->setTeacher($this);
       }

       return $this;
   }

   public function removeLesson(Lesson $lesson): self
   {
       if ($this->lessons->removeElement($lesson)) {
           // set the owning side to null (unless already changed)
           if ($lesson->getTeacher() === $this) {
               $lesson->setTeacher(null);
           }
       }

       return $this;
   }
}
