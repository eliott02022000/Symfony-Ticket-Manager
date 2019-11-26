<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketPostRepository")
 */
class TicketPost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MessagePost", mappedBy="ticket")
     */
    private $messagePosts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ticketPosts")
     */
    private $user;

    public function __construct()
    {
        $this->messagePosts = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    /**
     * @return Collection|MessagePost[]
     */
    public function getMessagePosts(): Collection
    {
        return $this->messagePosts;
    }

    public function addMessagePost(MessagePost $messagePost): self
    {
        if (!$this->messagePosts->contains($messagePost)) {
            $this->messagePosts[] = $messagePost;
            $messagePost->setTicket($this);
        }

        return $this;
    }

    public function removeMessagePost(MessagePost $messagePost): self
    {
        if ($this->messagePosts->contains($messagePost)) {
            $this->messagePosts->removeElement($messagePost);
            // set the owning side to null (unless already changed)
            if ($messagePost->getTicket() === $this) {
                $messagePost->setTicket(null);
            }
        }

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
