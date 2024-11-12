<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private array $url = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $isPublished = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAjout = null;

    #[ORM\ManyToOne(targetEntity: Album::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    // GETTERS ET SETTERS

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?array
    {
        return $this->url;
    }

    public function setUrl(array $url): self
    {
        $this->url = $url;
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

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;
        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(?\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;
        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;
        return $this;
    }
}
