<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\TablettesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TablettesRepository::class)]
class Tablettes
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
        minMessage: 'Le meta title doit faire plus de {{ limit }} caractères',
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
    private ?\DateTimeImmutable $ceated_at = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $quantite = null;

    #[ORM\OneToMany(mappedBy: 'tablette', targetEntity: TabletteImage::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'tablette')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

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

    public function getCeatedAt(): ?\DateTimeImmutable
    {
        return $this->ceated_at;
    }

    public function setCeatedAt(\DateTimeImmutable $ceated_at): static
    {
        $this->ceated_at = $ceated_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

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

    /**
     * @return Collection<int, TabletteImage>
     */
    public function getimages(): Collection
    {
        return $this->images;
    }

    public function addImage(TabletteImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setTablettes($this);
        }

        return $this;
    }

    public function removeImage(TabletteImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getTablettes() === $this) {
                $image->setTablettes(null);
            }
        }

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque_id): static
    {
        $this->marque = $marque_id;

        return $this;
    }
}
