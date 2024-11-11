<?php
namespace App\Entity;

use App\Repository\MembresRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: MembresRepository::class)]
class Membres implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $adressemail = null;

    #[ORM\Column(length: 255)]
    private ?string $motdepasse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $grade = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $club = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $PhotosDeprofil = null;  // Modification ici pour être un tableau

    public function __construct()
    {
        // Ajout d'un rôle par défaut
        $this->roles[] = 'ROLE_USER'; // Ajout du rôle "ROLE_USER" par défaut
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdressemail(): ?string
    {
        return $this->adressemail;
    }

    public function setAdressemail(string $adressemail): static
    {
        $this->adressemail = $adressemail;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): static
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getClub(): ?string
    {
        return $this->club;
    }

    public function setClub(?string $club): static
    {
        $this->club = $club;

        return $this;
    }

    // Implémentation de la méthode de l'interface UserInterface
    public function getUserIdentifier(): string
    {
        return $this->adressemail;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->motdepasse;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    // Implémentation de la méthode de l'interface PasswordAuthenticatedUserInterface
    public function eraseCredentials(): void
    {
        // Si tu stockes des informations sensibles comme des mots de passe temporaires, efface-les ici
    }

    public function getPhotosDeprofil(): ?string
    {
        return $this->PhotosDeprofil;
    }

    public function setPhotosDeprofil(?string $PhotosDeprofil): static
    {
        $this->PhotosDeprofil = $PhotosDeprofil;

        return $this;
    }
}
