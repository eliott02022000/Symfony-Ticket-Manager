<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessagePostRepository")
 */
class MessagePost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TicketPost", inversedBy="messagePosts")
     */
    private $ticket;

    /**
     * @ORM\Column(type="text")
     */
    private $MessageField;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="message")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getTicket(): ?TicketPost
    {
        return $this->ticket;
    }

    public function setTicket(?TicketPost $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getMessageField(): ?string
    {
        return $this->MessageField;
    }

    public function setMessageField(string $MessageField): self
    {
        $this->MessageField = $MessageField;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
