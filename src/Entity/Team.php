<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, Composer>
     */
    #[ORM\OneToMany(targetEntity: Composer::class, mappedBy: 'team', cascade:["remove"])]
    private Collection $composers;

    /**
     * @var Collection<int, Lier>
     */
    #[ORM\OneToMany(targetEntity: Lier::class, mappedBy: 'team', cascade:["remove"])]
    private Collection $liers;

    public function __construct()
    {
        $this->composers = new ArrayCollection();
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

    /**
     * @return Collection<int, Composer>
     */
    public function getComposers(): Collection
    {
        return $this->composers;
    }

    public function addComposer(Composer $composer): static
    {
        if (!$this->composers->contains($composer)) {
            $this->composers->add($composer);
            $composer->setTeam($this);
        }

        return $this;
    }

    public function removeComposer(Composer $composer): static
    {
        if ($this->composers->removeElement($composer)) {
            // set the owning side to null (unless already changed)
            if ($composer->getTeam() === $this) {
                $composer->setTeam(null);
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
            $lier->setTeam($this);
        }

        return $this;
    }

    public function removeLier(Lier $lier): static
    {
        if ($this->liers->removeElement($lier)) {
            // set the owning side to null (unless already changed)
            if ($lier->getTeam() === $this) {
                $lier->setTeam(null);
            }
        }

        return $this;
    }
}
