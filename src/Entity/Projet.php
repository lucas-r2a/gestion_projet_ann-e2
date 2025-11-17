<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTime $date_debut = null;

    #[ORM\Column]
    private ?\DateTime $date_fin_prevue = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $date_fin_reelle = null;

    /**
     * @var Collection<int, Tache>
     */
    #[ORM\OneToMany(targetEntity: Tache::class, mappedBy: 'id_projet')]
    private Collection $taches;

    /**
     * @var Collection<int, Lier>
     */
    #[ORM\OneToMany(targetEntity: Lier::class, mappedBy: 'idProjet')]
    private Collection $liers;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
        $this->liers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): static
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setIdProjet($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): static
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getIdProjet() === $this) {
                $tach->setIdProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lier>
     */
    public function getLiers(): Collection
    {
        return $this->liers;
    }

    public function addLier(Lier $lier): static
    {
        if (!$this->liers->contains($lier)) {
            $this->liers->add($lier);
            $lier->setProjet($this);
        }

        return $this;
    }

    public function removeLier(Lier $lier): static
    {
        if ($this->liers->removeElement($lier)) {
            // set the owning side to null (unless already changed)
            if ($lier->getProjet() === $this) {
                $lier->setProjet(null);
            }
        }

        return $this;
    }
}
