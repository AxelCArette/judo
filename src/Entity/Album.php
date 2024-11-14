<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $createdAt;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Photos::class, orphanRemoval: true)]
    private Collection $photos;

    #[ORM\Column(nullable: true)]
    private ?bool $Publier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PhotosDeCouverture = null;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->createdAt = new \DateTime(); // Initialisation de la date de création
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setAlbum($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // Set the owning side to null (unless already changed)
            if ($photo->getAlbum() === $this) {
                $photo->setAlbum(null);
            }
        }

        return $this;
    }

    // Ajoute la méthode __toString pour retourner le nom de l'album
    public function __toString(): string
    {
        return $this->name;
    }

    public function isPublier(): ?bool
    {
        return $this->Publier;
    }

    public function setPublier(?bool $Publier): static
    {
        $this->Publier = $Publier;

        return $this;
    }

    public function getPhotosDeCouverture(): ?string
    {
        return $this->PhotosDeCouverture;
    }

    public function setPhotosDeCouverture(?string $PhotosDeCouverture): static
    {
        $this->PhotosDeCouverture = $PhotosDeCouverture;

        return $this;
    }
}
