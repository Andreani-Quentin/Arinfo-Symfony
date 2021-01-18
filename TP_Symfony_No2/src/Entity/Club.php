<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
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
    private $nomClub;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sportClub;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseClub;

    /**
     * @ORM\OneToMany(targetEntity=Joueurs::class, mappedBy="clubJoueur")
     */
    private $joueurs;

    /**
     * @ORM\OneToMany(targetEntity=Equipes::class, mappedBy="clubEquipe")
     */
    private $equipes;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
        $this->equipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClub(): ?string
    {
        return $this->nomClub;
    }

    public function setNomClub(string $nomClub): self
    {
        $this->nomClub = $nomClub;

        return $this;
    }

    public function getSportClub(): ?string
    {
        return $this->sportClub;
    }

    public function setSportClub(string $sportClub): self
    {
        $this->sportClub = $sportClub;

        return $this;
    }

    public function getAdresseClub(): ?string
    {
        return $this->adresseClub;
    }

    public function setAdresseClub(string $adresseClub): self
    {
        $this->adresseClub = $adresseClub;

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
            $joueur->setClubJoueur($this);
        }

        return $this;
    }

    public function removeJoueur(Joueurs $joueur): self
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getClubJoueur() === $this) {
                $joueur->setClubJoueur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Equipes[]
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipes $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
            $equipe->setClubEquipe($this);
        }

        return $this;
    }

    public function removeEquipe(Equipes $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getClubEquipe() === $this) {
                $equipe->setClubEquipe(null);
            }
        }

        return $this;
    }
}
