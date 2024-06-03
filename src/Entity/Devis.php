<?php

// src/Entity/Devis.php
namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;

// Entité représentant un devis
#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    // Identifiant unique du devis
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    // Nom du client
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $clientName = null;

    // Description du devis
    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    // Montant du devis
    #[ORM\Column(type: 'float')]
    private ?float $amount = null;

    // Date de création du devis
    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    // Getters et setters pour chaque propriété

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): self
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
