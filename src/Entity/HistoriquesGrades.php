<?php

namespace App\Entity;

use App\Repository\HistoriquesGradesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriquesGradesRepository::class)]
class HistoriquesGrades
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $grade_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_obtention = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGradeId(): ?int
    {
        return $this->grade_id;
    }

    public function setGradeId(int $grade_id): static
    {
        $this->grade_id = $grade_id;

        return $this;
    }

    public function getDateObtention(): ?\DateTimeInterface
    {
        return $this->date_obtention;
    }

    public function setDateObtention(\DateTimeInterface $date_obtention): static
    {
        $this->date_obtention = $date_obtention;

        return $this;
    }
}
