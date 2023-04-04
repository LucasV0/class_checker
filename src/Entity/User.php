<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/*
class User
*/

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', nullable: true)]
   private ?string $googleAuthenticatorSecret;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $sexe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

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
}
