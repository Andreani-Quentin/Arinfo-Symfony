<?php

namespace App\Entity;

use App\Repository\ElevesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ElevesRepository::class)
 */
class Eleves
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
    private $nom_eleve;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_eleve;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $classe_eleve;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naissance_eleve;

    /**
     * @ORM\ManyToOne(targetEntity=classes::class, inversedBy="eleves")
     */
    private $id_classe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEleve(): ?string
    {
        return $this->nom_eleve;
    }

    public function setNomEleve(string $nom_eleve): self
    {
        $this->nom_eleve = $nom_eleve;

        return $this;
    }

    public function getPrenomEleve(): ?string
    {
        return $this->prenom_eleve;
    }

    public function setPrenomEleve(string $prenom_eleve): self
    {
        $this->prenom_eleve = $prenom_eleve;

        return $this;
    }

    public function getClasseEleve(): ?string
    {
        return $this->classe_eleve;
    }

    public function setClasseEleve(string $classe_eleve): self
    {
        $this->classe_eleve = $classe_eleve;

        return $this;
    }

    public function getDateNaissanceEleve(): ?\DateTimeInterface
    {
        return $this->date_naissance_eleve;
    }

    public function setDateNaissanceEleve(\DateTimeInterface $date_naissance_eleve): self
    {
        $this->date_naissance_eleve = $date_naissance_eleve;

        return $this;
    }

    public function getIdClasse(): ?classes
    {
        return $this->id_classe;
    }

    public function setIdClasse(?classes $id_classe): self
    {
        $this->id_classe = $id_classe;

        return $this;
    }
}
