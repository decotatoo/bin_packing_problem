<?php

namespace App\Entity;

use App\Repository\SimulationUnitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SimulationUnitRepository::class)]
class SimulationUnit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $qty;

    #[ORM\ManyToOne(targetEntity: Simulation::class, inversedBy: 'simulationUnits')]
    #[ORM\JoinColumn(nullable: false)]
    private $simulation;

    #[ORM\ManyToOne(targetEntity: Unit::class, inversedBy: 'simulationUnits')]
    #[ORM\JoinColumn(nullable: false)]
    private $unit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getSimulation(): ?Simulation
    {
        return $this->simulation;
    }

    public function setSimulation(?Simulation $simulation): self
    {
        $this->simulation = $simulation;

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }
}
