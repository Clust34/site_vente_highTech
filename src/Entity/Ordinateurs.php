<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Entity\OrdinateurImage;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\OrdinateursRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrdinateursRepository::class)]
class Ordinateurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Le nom doit faire plus de {{ limit }} caractères',
        maxMessage: 'Le nom ne peut pas faire plus de {{ limit }} caractères'
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['nom'])]
    private ?string $slug = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le meta itle doit faire plus de {{ limit }} caractères',
        maxMessage: 'Le meta title ne peut pas faire plus de {{ limit }} caractères'
    )]
    private ?string $metaTitle = null;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 200,
        minMessage: 'La meta description doit faire plus de {{ limit }} caractères',
        maxMessage: 'La meta description ne peut pas faire plus de {{ limit }} caractères'
    )]
    private ?string $metaDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $update_at = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $quantite = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'La marque doit faire plus de {{ limit }} caractères',
        maxMessage: 'La marque ne peut pas faire plus de {{ limit }} caractères'
    )]
    private ?string $marque = null;

    #[ORM\OneToMany(mappedBy: 'ordinateur', targetEntity: OrdinateurImage::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(string $metaTitle): static
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): static
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeImmutable $update_at): static
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection<int, OrdinateurImage>
     */
    public function getimages(): Collection
    {
        return $this->images;
    }

    public function addimage(OrdinateurImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setOrdinateurs($this);
        }

        return $this;
    }

    public function removeimage(OrdinateurImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getOrdinateurs() === $this) {
                $image->setOrdinateurs(null);
            }
        }

        return $this;
    }
}
