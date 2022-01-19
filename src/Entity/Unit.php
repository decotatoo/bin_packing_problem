<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $ref;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $w;

    #[ORM\Column(type: 'integer')]
    private $l;

    #[ORM\Column(type: 'integer')]
    private $h;

    #[ORM\OneToMany(mappedBy: 'unit', targetEntity: SimulationUnit::class, orphanRemoval: true)]
    private $simulationUnits;

    #[ORM\Column(type: 'integer')]
    private $weight;

    public function __construct()
    {
        $this->simulations = new ArrayCollection();
        $this->simulationUnits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getW(): ?int
    {
        return $this->w;
    }

    public function setW(int $w): self
    {
        $this->w = $w;

        return $this;
    }

    public function getL(): ?int
    {
        return $this->l;
    }

    public function setL(int $l): self
    {
        $this->l = $l;

        return $this;
    }

    public function getH(): ?int
    {
        return $this->h;
    }

    public function setH(int $h): self
    {
        $this->h = $h;

        return $this;
    }

    /**
     * @return Collection|SimulationUnit[]
     */
    public function getSimulationUnits(): Collection
    {
        return $this->simulationUnits;
    }

    public function addSimulationUnit(SimulationUnit $simulationUnit): self
    {
        if (!$this->simulationUnits->contains($simulationUnit)) {
            $this->simulationUnits[] = $simulationUnit;
            $simulationUnit->setUnit($this);
        }

        return $this;
    }

    public function removeSimulationUnit(SimulationUnit $simulationUnit): self
    {
        if ($this->simulationUnits->removeElement($simulationUnit)) {
            // set the owning side to null (unless already changed)
            if ($simulationUnit->getUnit() === $this) {
                $simulationUnit->setUnit(null);
            }
        }

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}
