<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRepository::class)]
class Tache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTime $date_debut = null;

    #[ORM\Column]
    private ?\DateTime $date_fin_prevue = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $date_fin_reelle = null;

    #[ORM\Column(length: 100)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $id_projet = null;

    /**
     * @var Collection<int, Assigner>
     */
    #[ORM\OneToMany(targetEntity: Assigner::class, mappedBy: 'id_tache')]
    private Collection $assigners;

    public function __construct()
    {
        $this->assigners = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTime
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTime $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFinPrevue(): ?\DateTime
    {
        return $this->date_fin_prevue;
    }

    public function setDateFinPrevue(\DateTime $date_fin_prevue): static
    {
        $this->date_fin_prevue = $date_fin_prevue;

        return $this;
    }

    public function getDateFinReelle(): ?\DateTime
    {
        return $this->date_fin_reelle;
    }

    public function setDateFinReelle(?\DateTime $date_fin_reelle): static
    {
        $this->date_fin_reelle = $date_fin_reelle;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getIdProjet(): ?Projet
    {
        return $this->id_projet;
    }

    public function setIdProjet(?Projet $id_projet): static
    {
        $this->id_projet = $id_projet;

        return $this;
    }

    /**
     * @return Collection<int, Assigner>
     */
    public function getAssigners(): Collection
    {
        return $this->assigners;
    }

    public function addAssigner(Assigner $assigner): static
    {
        if (!$this->assigners->contains($assigner)) {
            $this->assigners->add($assigner);
            $assigner->setTache($this);
        }

        return $this;
    }

    public function removeAssigner(Assigner $assigner): static
    {
        if ($this->assigners->removeElement($assigner)) {
            // set the owning side to null (unless already changed)
            if ($assigner->getTache() === $this) {
                $assigner->setTache(null);
            }
        }

        return $this;
    }
}
