<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomDeLaPersonne = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomdelapersonne = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $textedelapersonne = null;

    #[ORM\Column(length: 255)]
    private ?string $adressemail = null;

    #[ORM\Column(nullable: true)]
    private ?int $numerodetelephonedelapersonne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDeLaPersonne(): ?string
    {
        return $this->NomDeLaPersonne;
    }

    public function setNomDeLaPersonne(string $NomDeLaPersonne): static
    {
        $this->NomDeLaPersonne = $NomDeLaPersonne;

        return $this;
    }

    public function getPrenomdelapersonne(): ?string
    {
        return $this->prenomdelapersonne;
    }

    public function setPrenomdelapersonne(string $prenomdelapersonne): static
    {
        $this->prenomdelapersonne = $prenomdelapersonne;

        return $this;
    }

    public function getTextedelapersonne(): ?string
    {
        return $this->textedelapersonne;
    }

    public function setTextedelapersonne(string $textedelapersonne): static
    {
        $this->textedelapersonne = $textedelapersonne;

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

    public function getNumerodetelephonedelapersonne(): ?int
    {
        return $this->numerodetelephonedelapersonne;
    }

    public function setNumerodetelephonedelapersonne(?int $numerodetelephonedelapersonne): static
    {
        $this->numerodetelephonedelapersonne = $numerodetelephonedelapersonne;

        return $this;
    }
}
