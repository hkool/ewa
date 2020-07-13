<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Exception;


/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 * @ORM\HasLifecycleCallbacks
 */
class Contact
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
    private $name="";

    /**
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email="";

    /**
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message="";
    
    /**
     * @ORM\Column(name="subscribed", type="boolean", nullable=true)
     */
    private $subscribed = 0;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSubscribed(): ?bool
    {
        return $this->subscribed;
    }

    public function setSubscribed(?bool $subscribed): self
    {
        $this->subscribed = $subscribed;

        return $this;
    }

    public function getCreated(): DateTime
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
