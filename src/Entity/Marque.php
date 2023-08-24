<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Telephones::class, orphanRemoval: true)]
    private Collection $telephone;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Ordinateurs::class, orphanRemoval: true)]
    private Collection $ordinateur;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Tablettes::class, orphanRemoval: true)]
    private Collection $tablette;



    public function __construct()
    {
        $this->telephone = new ArrayCollection();
        $this->ordinateur = new ArrayCollection();
        $this->tablette = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Telephones>
     */
    public function getTelephones(): Collection
    {
        return $this->telephone;
    }

    public function addTelephone(Telephones $telephoneId): static
    {
        if (!$this->telephone->contains($telephoneId)) {
            $this->telephone->add($telephoneId);
            $telephoneId->setMarque($this);
        }

        return $this;
    }

    public function removeTelephone(Telephones $telephoneId): static
    {
        if ($this->telephone->removeElement($telephoneId)) {
            // set the owning side to null (unless already changed)
            if ($telephoneId->getMarque() === $this) {
                $telephoneId->setMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ordinateurs>
     */
    public function getOrdinateurs(): Collection
    {
        return $this->ordinateur;
    }

    public function addOrdinateur(Ordinateurs $ordinateurId): static
    {
        if (!$this->ordinateur->contains($ordinateurId)) {
            $this->ordinateur->add($ordinateurId);
            $ordinateurId->setMarque($this);
        }

        return $this;
    }

    public function removeOrdinateur(Ordinateurs $ordinateurId): static
    {
        if ($this->ordinateur->removeElement($ordinateurId)) {
            // set the owning side to null (unless already changed)
            if ($ordinateurId->getMarque() === $this) {
                $ordinateurId->setMarque(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tablettes>
     */
    public function getTablettes(): Collection
    {
        return $this->tablette;
    }

    public function addTablette(Tablettes $tabletteId): static
    {
        if (!$this->tablette->contains($tabletteId)) {
            $this->tablette->add($tabletteId);
            $tabletteId->setMarque($this);
        }

        return $this;
    }

    public function removeTablette(Tablettes $tabletteId): static
    {
        if ($this->tablette->removeElement($tabletteId)) {
            // set the owning side to null (unless already changed)
            if ($tabletteId->getMarque() === $this) {
                $tabletteId->setMarque(null);
            }
        }

        return $this;
    }
}
