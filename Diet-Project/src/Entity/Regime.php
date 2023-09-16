<?php

namespace App\Entity;

use App\Repository\RegimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegimeRepository::class)
 */
class Regime

{   
    // Autres champs de l'entité

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uploadImage;

    // Getters et setters pour le champ uploadImage






    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomRegime;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Plat::class, mappedBy="regime")
     */
    private $Plat;

    public function __construct()
    {
        $this->Plat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRegime(): ?string
    {
        return $this->nomRegime;
    }

    public function setNomRegime(string $nomRegime): self
    {
        $this->nomRegime = $nomRegime;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Plat>
     */
    public function getPlat(): Collection
    {
        return $this->Plat;
    }

    public function addPlat(Plat $plat): self
    {
        if (!$this->Plat->contains($plat)) {
            $this->Plat[] = $plat;
            $plat->setRegime($this);
        }

        return $this;
    }

    public function removePlat(Plat $plat): self
    {
        if ($this->Plat->removeElement($plat)) {
            // set the owning side to null (unless already changed)
            if ($plat->getRegime() === $this) {
                $plat->setRegime(null);
            }
        }

        return $this;
    }

    
}
