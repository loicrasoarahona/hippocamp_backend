<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\CustomFilters\CaseInsensitiveSearchFilter;
use App\Repository\TeacherRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: TeacherRepository::class)]
#[ApiResource(operations: [
    new GetCollection(),
    new Get(),
    new Put(),
    new Post(),
    new Patch(),
    new Delete()
])]
#[ApiFilter(CaseInsensitiveSearchFilter::class, properties: ["name", "surname"])]
#[ApiFilter(SearchFilter::class, properties: ['authorized' => 'exact', 'm_user.id' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['name', 'authorized'])]
class Teacher
{
    #[Groups(['teacher:collection', 'course:item'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['teacher:collection', 'course:item'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['teacher:collection', 'course:item'])]
    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[Groups(['teacher:collection', 'course:item'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $birthdate = null;

    #[Groups(['teacher:collection', 'course:item'])]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Groups(['teacher:collection', 'course:item'])]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $m_user = null;

    /**
     * @var Collection<int, Course>
     */
    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'teachers')]
    private Collection $courses;

    #[ORM\Column]
    private ?bool $authorized = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['teacher:collection', "course:item"])]
    #[ORM\Column(length: 1)]
    private ?string $gender = null;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setDefaultCreatedAt()
    {
        $this->createdAt = new DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTime $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getMUser(): ?User
    {
        return $this->m_user;
    }

    public function setMUser(User $m_user): static
    {
        $this->m_user = $m_user;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->addTeacher($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            $course->removeTeacher($this);
        }

        return $this;
    }

    public function isAuthorized(): ?bool
    {
        return $this->authorized;
    }

    public function setAuthorized(bool $authorized): static
    {
        $this->authorized = $authorized;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }
}
