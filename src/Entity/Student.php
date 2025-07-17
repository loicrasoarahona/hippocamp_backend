<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\StudentRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['m_user.id' => 'exact'])]
class Student
{
    #[Groups(['studentCourse:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['studentCourse:collection'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['studentCourse:collection'])]
    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[Groups(['studentCourse:collection'])]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Groups(['studentCourse:collection'])]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[Groups(['studentCourse:collection'])]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $m_user = null;

    #[Groups(['studentCourse:collection'])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $birthdate = null;

    /**
     * @var Collection<int, StudentCourse>
     */
    #[ORM\OneToMany(targetEntity: StudentCourse::class, mappedBy: 'student', orphanRemoval: true)]
    private Collection $studentCourses;

    public function __construct()
    {
        $this->studentCourses = new ArrayCollection();
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

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTime $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return Collection<int, StudentCourse>
     */
    public function getStudentCourses(): Collection
    {
        return $this->studentCourses;
    }

    public function addStudentCourse(StudentCourse $studentCourse): static
    {
        if (!$this->studentCourses->contains($studentCourse)) {
            $this->studentCourses->add($studentCourse);
            $studentCourse->setStudent($this);
        }

        return $this;
    }

    public function removeStudentCourse(StudentCourse $studentCourse): static
    {
        if ($this->studentCourses->removeElement($studentCourse)) {
            // set the owning side to null (unless already changed)
            if ($studentCourse->getStudent() === $this) {
                $studentCourse->setStudent(null);
            }
        }

        return $this;
    }
}
