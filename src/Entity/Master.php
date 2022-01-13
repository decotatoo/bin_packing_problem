<?php

namespace App\Entity;

use App\Repository\MasterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MasterRepository::class)]
class Master
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
    private $base_weight;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $max_weight;

    #[ORM\Column(type: 'integer')]
    private $in_w;

    #[ORM\Column(type: 'integer')]
    private $in_l;

    #[ORM\Column(type: 'integer')]
    private $in_d;

    #[ORM\Column(type: 'integer')]
    private $out_w;

    #[ORM\Column(type: 'integer')]
    private $out_l;

    #[ORM\Column(type: 'integer')]
    private $out_d;

    #[ORM\ManyToMany(targetEntity: Simulation::class, mappedBy: 'masters')]
    private $simulations;

    public function __construct()
    {
        $this->simulations = new ArrayCollection();
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

    public function getBaseWeight(): ?int
    {
        return $this->base_weight;
    }

    public function setBaseWeight(int $base_weight): self
    {
        $this->base_weight = $base_weight;

        return $this;
    }

    public function getMaxWeight(): ?int
    {
        return $this->max_weight;
    }

    public function setMaxWeight(?int $max_weight): self
    {
        $this->max_weight = $max_weight;

        return $this;
    }

    public function getInW(): ?int
    {
        return $this->in_w;
    }

    public function setInW(int $in_w): self
    {
        $this->in_w = $in_w;

        return $this;
    }

    public function getInL(): ?int
    {
        return $this->in_l;
    }

    public function setInL(int $in_l): self
    {
        $this->in_l = $in_l;

        return $this;
    }

    public function getInD(): ?int
    {
        return $this->in_d;
    }

    public function setInD(int $in_d): self
    {
        $this->in_d = $in_d;

        return $this;
    }

    public function getOutW(): ?int
    {
        return $this->out_w;
    }

    public function setOutW(int $out_w): self
    {
        $this->out_w = $out_w;

        return $this;
    }

    public function getOutL(): ?int
    {
        return $this->out_l;
    }

    public function setOutL(int $out_l): self
    {
        $this->out_l = $out_l;

        return $this;
    }

    public function getOutD(): ?int
    {
        return $this->out_d;
    }

    public function setOutD(int $out_d): self
    {
        $this->out_d = $out_d;

        return $this;
    }

    /**
     * @return Collection|Simulation[]
     */
    public function getSimulations(): Collection
    {
        return $this->simulations;
    }

    public function addSimulation(Simulation $simulation): self
    {
        if (!$this->simulations->contains($simulation)) {
            $this->simulations[] = $simulation;
            $simulation->addMaster($this);
        }

        return $this;
    }

    public function removeSimulation(Simulation $simulation): self
    {
        if ($this->simulations->removeElement($simulation)) {
            $simulation->removeMaster($this);
        }

        return $this;
    }
}
