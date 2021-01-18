<?php

namespace App\Entity;

use App\Repository\EquipesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipesRepository::class)
 */
class Equipes
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
    private $nomEquipe;

    /**
     * @ORM\OneToMany(targetEntity=Joueurs::class, mappedBy="equipeJoueur")
     */
    private $joueurs;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="equipes")
     */
    private $clubEquipe;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEquipe(): ?string
    {
        return $this->nomEquipe;
    }

    public function setNomEquipe(string $nomEquipe): self
    {
        $this->nomEquipe = $nomEquipe;

        return $this;
    }

    /**
     * @return Collection|Joueurs[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueurs $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
            $joueur->setEquipeJoueur($this);
        }

        return $this;
    }

    public function removeJoueur(Joueurs $joueur): self
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getEquipeJoueur() === $this) {
                $joueur->setEquipeJoueur(null);
            }
        }

        return $this;
    }

    public function getClubEquipe(): ?Club
    {
        return $this->clubEquipe;
    }

    public function setClubEquipe(?Club $clubEquipe): self
    {
        $this->clubEquipe = $clubEquipe;

        return $this;
    }
}
