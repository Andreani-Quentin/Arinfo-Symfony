<?php

namespace App\Entity;

use App\Repository\JoueursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

/**
 * @ORM\Entity(repositoryClass=JoueursRepository::class)
 */
class Joueurs
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
    private $nomJoueur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomJoueur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoJoueur;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="joueurs")
     */
    private $clubJoueur;

    /**
     * @ORM\ManyToOne(targetEntity=Equipes::class, inversedBy="joueurs")
     */
    private $equipeJoueur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomJoueur(): ?string
    {
        return $this->nomJoueur;
    }

    public function setNomJoueur(string $nomJoueur): self
    {
        $this->nomJoueur = $nomJoueur;

        return $this;
    }

    public function getPrenomJoueur(): ?string
    {
        return $this->prenomJoueur;
    }

    public function setPrenomJoueur(string $prenomJoueur): self
    {
        $this->prenomJoueur = $prenomJoueur;

        return $this;
    }

    public function getPhotoJoueur(): ?string
    {
        return $this->photoJoueur;
    }

    public function setPhotoJoueur(string $photoJoueur): self
    {
        $this->photoJoueur = $photoJoueur;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getClubJoueur(): ?Club
    {
        return $this->clubJoueur;
    }

    public function setClubJoueur(?Club $clubJoueur): self
    {
        $this->clubJoueur = $clubJoueur;

        return $this;
    }

    public function getEquipeJoueur(): ?Equipes
    {
        return $this->equipeJoueur;
    }

    public function setEquipeJoueur(?Equipes $equipeJoueur): self
    {
        $this->equipeJoueur = $equipeJoueur;

        return $this;
    }
}
