<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_grade = null;

    #[ORM\Column(length: 255)]
    private ?string $date_obtention_grade = null;

    #[ORM\Column]
    private ?int $id_membres = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGrade(): ?string
    {
        return $this->nom_grade;
    }

    public function setNomGrade(string $nom_grade): static
    {
        $this->nom_grade = $nom_grade;

        return $this;
    }

    public function getDateObtentionGrade(): ?string
    {
        return $this->date_obtention_grade;
    }

    public function setDateObtentionGrade(string $date_obtention_grade): static
    {
        $this->date_obtention_grade = $date_obtention_grade;

        return $this;
    }

    public function getIdMembres(): ?int
    {
        return $this->id_membres;
    }

    public function setIdMembres(int $id_membres): static
    {
        $this->id_membres = $id_membres;

        return $this;
    }
}
