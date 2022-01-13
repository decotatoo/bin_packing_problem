<?php

namespace App\Entity;

use App\Repository\SimulationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SimulationRepository::class)]
class Simulation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Master::class, inversedBy: 'simulations')]
    private $masters;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'json', nullable: true)]
    private $result = [];

    #[ORM\OneToMany(mappedBy: 'simulation', targetEntity: SimulationUnit::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private $simulationUnits;

    public function __construct()
    {
        $this->masters = new ArrayCollection();
        $this->simulationUnits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Master[]
     */
    public function getMasters(): Collection
    {
        return $this->masters;
    }

    public function addMaster(Master $master): self
    {
        if (!$this->masters->contains($master)) {
            $this->masters[] = $master;
        }

        return $this;
    }

    public function removeMaster(Master $master): self
    {
        $this->masters->removeElement($master);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getResult(): ?array
    {
        return $this->result;
    }

    public function setResult(?array $result): self
    {
        $this->result = $result;

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
            $simulationUnit->setSimulation($this);
        }

        return $this;
    }

    public function removeSimulationUnit(SimulationUnit $simulationUnit): self
    {
        if ($this->simulationUnits->removeElement($simulationUnit)) {
            // set the owning side to null (unless already changed)
            if ($simulationUnit->getSimulation() === $this) {
                $simulationUnit->setSimulation(null);
            }
        }

        return $this;
    }
}
