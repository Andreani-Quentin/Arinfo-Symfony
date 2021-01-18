<?php

namespace App\Entity;

use App\Repository\ProffesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProffesseurRepository::class)
 */
class Proffesseur
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
    private $nom_professeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_professeur;

    /**
     * @ORM\OneToMany(targetEntity=Classes::class, mappedBy="professeur")
     */
    private $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProfesseur(): ?string
    {
        return $this->nom_professeur;
    }

    public function setNomProfesseur(string $nom_professeur): self
    {
        $this->nom_professeur = $nom_professeur;

        return $this;
    }

    public function getPrenomProfesseur(): ?string
    {
        return $this->prenom_professeur;
    }

    public function setPrenomProfesseur(string $prenom_professeur): self
    {
        $this->prenom_professeur = $prenom_professeur;

        return $this;
    }

    public function getClasses(): ?Classes
    {
        return $this->classes;
    }

    public function setClasses(?Classes $classes): self
    {
        // unset the owning side of the relation if necessary
        if ($classes === null && $this->classes !== null) {
            $this->classes->setIdProfesseur(null);
        }

        // set the owning side of the relation if necessary
        if ($classes !== null && $classes->getIdProfesseur() !== $this) {
            $classes->setIdProfesseur($this);
        }

        $this->classes = $classes;

        return $this;
    }

    public function addClass(Classes $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->setProfesseur($this);
        }

        return $this;
    }

    public function removeClass(Classes $class): self
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getProfesseur() === $this) {
                $class->setProfesseur(null);
            }
        }

        return $this;
    }
}
