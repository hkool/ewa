<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Exception;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 *
 * Base
 *
 * @Vich\Uploadable
 * @ORM\Entity
 * @ORM\Table(name="partner")
 * @ORM\HasLifecycleCallbacks
 */
class Partner
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(name="image", type="string", nullable=true)
     *
     * @var string|null
     */
    private $image;

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     */
    public function setImageFile($imageFile): void
    {
        $this->imageFile = $imageFile;
    }
    /**
     *
     * @Vich\UploadableField(mapping="imageFile", fileNameProperty="image")
     *
     *
     */
    protected $imageFile;

    /**
     * @return mixed
     */
    public function getPartnerImage()
    {
        return $this->partnerImage;
    }

    /**
     * @param mixed $partnerImage
     */
    public function setPartnerImage($partnerImage): void
    {
        $this->partnerImage = $partnerImage;
    }


    /**
     * @ORM\Column(name="created", type="datetime")
     *
     * @var DateTime
     */
    private $created;

    /**
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     *
     * @var DateTime|null
     */
    private $updated;

    /**
     * @ORM\PrePersist
     *
     * @throws Exception;
     */
    public function onPrePersist(): void
    {
        $this->created = new DateTime('NOW');
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->updated = new DateTime('NOW');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
