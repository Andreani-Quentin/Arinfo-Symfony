<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassesRepository::class)
 */
class Classes
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
    private $nom_classe;



    /**
     * @ORM\OneToMany(targetEntity=Eleves::class, mappedBy="id_classe")
     */
    private $eleves;

    /**
     * @ORM\ManyToOne(targetEntity=Proffesseur::class, inversedBy="classes")
     */
    private $professeur;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClasse(): ?string
    {
        return $this->nom_classe;
    }

    public function setNomClasse(string $nom_classe): self
    {
        $this->nom_classe = $nom_classe;

        return $this;
    }

    public function getIdProfesseur(): ?proffesseur
    {
        return $this->id_professeur;
    }

    public function setIdProfesseur(?proffesseur $id_professeur): self
    {
        $this->id_professeur = $id_professeur;

        return $this;
    }

    /**
     * @return Collection|Eleves[]
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleves $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves[] = $elefe;
            $elefe->setIdClasse($this);
        }

        return $this;
    }

    public function removeElefe(Eleves $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getIdClasse() === $this) {
                $elefe->setIdClasse(null);
            }
        }

        return $this;
    }

    public function getProfesseur(): ?Proffesseur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Proffesseur $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }
}
