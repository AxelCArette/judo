<?php

namespace App\Entity;

use App\Repository\MembresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
    private ?string $PhotosDeprofil = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    // Relation One-to-Many avec l'entité Post
    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Post::class)]
    private Collection $posts;

    public function __construct()
    {
        // Initialiser la collection de posts
        $this->posts = new ArrayCollection();
        
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    // Méthodes pour accéder aux posts d'un membre
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setMembre($this); // Associe le membre au post
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            // Si l'élément est supprimé, on délie également le post du membre
            if ($post->getMembre() === $this) {
                $post->setMembre(null);
            }
        }

        return $this;
    }
}
