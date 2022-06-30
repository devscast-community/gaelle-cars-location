<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $membre;

    #[ORM\ManyToOne(targetEntity: Vehicule::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $vehicule;

    #[ORM\Column(type: 'datetime_immutable')]
    private $date_heure_depart;

    #[ORM\Column(type: 'datetime_immutable')]
    private $date_heure_fin;

    #[ORM\Column(type: 'float')]
    private $prix_total;

    #[ORM\Column(type: 'date_immutable')]
    private $date_enregistrement;

    public function __construct()
    {
        $this->date_enregistrement = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembre(): ?User
    {
        return $this->membre;
    }

    public function setMembre(?User $membre): self
    {
        $this->membre = $membre;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getDateHeureDepart(): ?\DateTimeImmutable
    {
        return $this->date_heure_depart;
    }

    public function setDateHeureDepart(\DateTimeInterface $date_heure_depart): self
    {
        $this->date_heure_depart = $date_heure_depart;

        if ($date_heure_depart instanceof  \DateTime) {
            $this->date_heure_depart = \DateTimeImmutable::createFromInterface($date_heure_depart);
        }

        return $this;
    }

    public function getDateHeureFin(): ?\DateTimeImmutable
    {
        return $this->date_heure_fin;
    }

    public function setDateHeureFin(\DateTimeInterface $date_heure_fin): self
    {
        $this->date_heure_fin = $date_heure_fin;

        if ($date_heure_fin instanceof \DateTime) {
            $this->date_heure_fin = \DateTimeImmutable::createFromInterface($date_heure_fin);
        }

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prix_total;
    }

    public function setPrixTotal(float $prix_total): self
    {
        $this->prix_total = $prix_total;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeImmutable
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(\DateTimeImmutable $date_enregistrement): self
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }
}
