<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlatRepository::class)
 */
class Plat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomPlat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $cout;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrCalorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ingredients;

    /**
     * @ORM\ManyToOne(targetEntity=Regime::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Regime;

    /**
     * @ORM\ManyToOne(targetEntity=Regime::class, inversedBy="Plat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $regime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPlat(): ?string
    {
        return $this->nomPlat;
    }

    public function setNomPlat(string $nomPlat): self
    {
        $this->nomPlat = $nomPlat;

        return $this;
    }

    public function getCout(): ?string
    {
        return $this->cout;
    }

    public function setCout(string $cout): self
    {
        $this->cout = $cout;

        return $this;
    }

    public function getNbrCalorie(): ?int
    {
        return $this->nbrCalorie;
    }

    public function setNbrCalorie(int $nbrCalorie): self
    {
        $this->nbrCalorie = $nbrCalorie;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->Ingredients;
    }

    public function setIngredients(string $Ingredients): self
    {
        $this->Ingredients = $Ingredients;

        return $this;
    }

    public function getRegime(): ?Regime
    {
        return $this->Regime;
    }

    public function setRegime(?Regime $Regime): self
    {
        $this->Regime = $Regime;

        return $this;
    }
}
