<?php

namespace App\Entity;

use App\Repository\NotationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotationRepository::class)
 */
class Notation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $note;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="notations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getRestaurantId(): ?Restaurant
    {
        return $this->restaurant_id;
    }

    public function setRestaurantId(?Restaurant $restaurant_id): self
    {
        $this->restaurant_id = $restaurant_id;

        return $this;
    }

    public function getUtilisateurId(): ?User
    {
        return $this->utilisateur_id;
    }

    public function setUtilisateurId(?User $utilisateur_id): self
    {
        $this->utilisateur_id = $utilisateur_id;

        return $this;
    }
}
