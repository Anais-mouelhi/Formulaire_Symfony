<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant un utilisateur
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    // Identifiant unique de l'utilisateur
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Nom de l'utilisateur
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    // Prénom de l'utilisateur
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    // Adresse email de l'utilisateur
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    // Genre de l'utilisateur
    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    // Consentement RGPD de l'utilisateur
    #[ORM\Column]
    private ?bool $rgpd = null;

    // Getters et setters pour chaque propriété

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function isRgpd(): ?bool
    {
        return $this->rgpd;
    }

    public function setRgpd(bool $rgpd): self
    {
        $this->rgpd = $rgpd;

        return $this;
    }
}
