<?php

namespace App\Entity;

use App\Repository\SponsorsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SponsorsRepository::class)]
class Sponsors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_sponsors = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo_url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $liensiteweb = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSponsors(): ?string
    {
        return $this->nom_sponsors;
    }

    public function setNomSponsors(string $nom_sponsors): static
    {
        $this->nom_sponsors = $nom_sponsors;

        return $this;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logo_url;
    }

    public function setLogoUrl(?string $logo_url): static
    {
        $this->logo_url = $logo_url;

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

    public function getLiensiteweb(): ?string
    {
        return $this->liensiteweb;
    }

    public function setLiensiteweb(?string $liensiteweb): static
    {
        $this->liensiteweb = $liensiteweb;

        return $this;
    }
}
