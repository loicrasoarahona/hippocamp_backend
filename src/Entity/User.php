<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\EventListener\UserListener;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\EntityListeners([UserListener::class])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(operations: [
    new GetCollection(),
    new Get(),
    new Put(),
    new Post(),
    new Patch(formats: ["json"]),
    new Delete()
])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['user:collection', 'coursePrivateChatMessage:collection', 'coursePrivateChat:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['user:collection'])]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Groups(['user:collection'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserRole $role = null;

    /**
     * @var Collection<int, CourseForum>
     */
    #[ORM\OneToMany(targetEntity: CourseForum::class, mappedBy: 'm_user')]
    private Collection $courseForums;

    public function __construct()
    {
        $this->courseForums = new ArrayCollection();
    }


    public function getRoles(): array
    {
        $roleName = $this->role->getName();
        return [$roleName];
    }

    public function eraseCredentials(): void {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?UserRole
    {
        return $this->role;
    }

    public function setRole(?UserRole $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, CourseForum>
     */
    public function getCourseForums(): Collection
    {
        return $this->courseForums;
    }

    public function addCourseForum(CourseForum $courseForum): static
    {
        if (!$this->courseForums->contains($courseForum)) {
            $this->courseForums->add($courseForum);
            $courseForum->setMUser($this);
        }

        return $this;
    }

    public function removeCourseForum(CourseForum $courseForum): static
    {
        if ($this->courseForums->removeElement($courseForum)) {
            // set the owning side to null (unless already changed)
            if ($courseForum->getMUser() === $this) {
                $courseForum->setMUser(null);
            }
        }

        return $this;
    }
}
