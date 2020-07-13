<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 *
 * Base
 *
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="posts")
 * @ORM\HasLifecycleCallbacks
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="title", length=100, type="string")
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(name="content", length=50000, type="string")
     *
     * @var string
     */
    private $content;

    /**
     * @ORM\Column(name="reaction", type="string", nullable=true)
     *
     * @var string|null
     */
     private $reaction;
    /**
     * @ORM\Column(name="image", type="string", nullable=true)
     *
     * @var string|null
     */
    private $image;
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
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     *
     * @var DateTime|null
     */
    private $updated;

    /**
     * @param UploadedFile $file
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;
        $this->updated = new \DateTime();
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\Column(name="created", type="datetime")
     *
     * @var DateTime
     */
    private $created;

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @param DateTime|null $updated
     */
    public function setUpdated(?DateTime $updated): void
    {
        $this->updated = $updated;
    }



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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getReaction(): ?int
    {
        return $this->reaction;
    }

    public function setReaction(?int $reaction): self
    {
        $this->reaction = $reaction;

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
    public function setImage($image): void
    {
        $this->image = $image;
    }
    public function getImage(): ?string {
        return $this->image;
    }



    
}
