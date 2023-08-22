<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TelephoneImageRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TelephoneImageRepository::class)]
#[Vich\Uploadable]
class TelephoneImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'telephone_image', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $image = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'images', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Telephones $telephones = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of image
     *
     * @return ?File
     */
    public function getImage(): ?File
    {
        return $this->image;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImage(File $imageFile = null): self
    {
        $this->image = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get the value of imageName
     *
     * @return ?string
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * Set the value of imageName
     *
     * @param ?string $imageName
     *
     * @return self
     */
    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get the value of imageSize
     *
     * @return ?int
     */
    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * Set the value of imageSize
     *
     * @param ?int $imageSize
     *
     * @return self
     */
    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return ?\DateTimeImmutable
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param ?\DateTimeImmutable $updatedAt
     *
     * @return static
     */
    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of telephones
     *
     * @return ?Telephones
     */
    public function getTelephones(): ?Telephones
    {
        return $this->telephones;
    }

    /**
     * Set the value of telephones
     *
     * @param ?Telephones $telephones
     *
     * @return static
     */
    public function setTelephones(?Telephones $telephones): static
    {
        $this->telephones = $telephones;

        return $this;
    }
}
