<?php

namespace App\Entity;

use App\Repository\LierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LierRepository::class)]
class Lier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'liers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $idTeam = null;

    #[ORM\ManyToOne(inversedBy: 'liers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $idProjet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTeam(): ?Team
    {
        return $this->idTeam;
    }

    public function setIdTeam(?Team $idTeam): static
    {
        $this->idTeam = $idTeam;

        return $this;
    }

    public function getIdProjet(): ?Projet
    {
        return $this->idProjet;
    }

    public function setIdProjet(?Projet $idProjet): static
    {
        $this->idProjet = $idProjet;

        return $this;
    }
}
