<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TicketPost", mappedBy="user")
     */
    private $ticketPosts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MessagePost", mappedBy="user", cascade={"all"})
     */
    private $message;

    public function __construct()
    {
        $this->ticketPosts = new ArrayCollection();
        $this->message = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    
    function addRole($role) {
        $this->roles[] = $role;
    }


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|TicketPost[]
     */
    public function getTicketPosts(): Collection
    {
        return $this->ticketPosts;
    }

    public function addTicketPost(TicketPost $ticketPost): self
    {
        if (!$this->ticketPosts->contains($ticketPost)) {
            $this->ticketPosts[] = $ticketPost;
            $ticketPost->setUser($this);
        }

        return $this;
    }

    public function removeTicketPost(TicketPost $ticketPost): self
    {
        if ($this->ticketPosts->contains($ticketPost)) {
            $this->ticketPosts->removeElement($ticketPost);
            // set the owning side to null (unless already changed)
            if ($ticketPost->getUser() === $this) {
                $ticketPost->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MessagePost[]
     */
    public function getMessage(): Collection
    {
        return $this->message;
    }

    public function addMessage(MessagePost $message): self
    {
        if (!$this->message->contains($message)) {
            $this->message[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(MessagePost $message): self
    {
        if ($this->message->contains($message)) {
            $this->message->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

}
