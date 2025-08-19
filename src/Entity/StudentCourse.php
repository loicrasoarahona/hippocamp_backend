<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operations;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\StudentCourseRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: StudentCourseRepository::class)]
#[ORM\Table(name: 'student_course', uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'unique_student_course', columns: ['course', 'student'])
])]
#[UniqueEntity(fields: ['course', 'student'], message: 'Cet utilisateur est déjà inscrit à ce cours.')]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['studentCourse:collection']]),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['course' => 'exact', 'student' => 'exact'])]
#[ApiFilter(ExistsFilter::class, properties: ['registeredAt'])]
#[ApiFilter(OrderFilter::class, properties: ['requestedAt', 'registeredAt'])]
class StudentCourse
{
    #[Groups(["studentCourse:collection", "student:item", "student:collection"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["studentCourse:collection", "student:item", "student:collection"])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[Groups(["studentCourse:collection"])]
    #[ORM\ManyToOne(inversedBy: 'studentCourses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[Groups(["studentCourse:collection", "student:item", "student:collection"])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $registeredAt = null;


    #[Groups(["studentCourse:collection", "student:item", "student:collection"])]
    #[ORM\Column]
    private ?\DateTimeImmutable $requestedAt = null;

    #[Groups(["studentCourse:collection", "student:item", "student:collection"])]
    #[ORM\ManyToOne]
    private ?User $registeredBy = null;

    /**
     * @var Collection<int, StudentCourseEndedChapter>
     */
    #[ORM\OneToMany(targetEntity: StudentCourseEndedChapter::class, mappedBy: 'studentCourse', orphanRemoval: true)]
    private Collection $endedChapters;

    public function __construct()
    {
        $this->endedChapters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(?\DateTimeImmutable $registeredAt): static
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getRequestedAt(): ?\DateTimeImmutable
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTimeImmutable $requestedAt): static
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }

    public function getRegisteredBy(): ?User
    {
        return $this->registeredBy;
    }

    public function setRegisteredBy(?User $registeredBy): static
    {
        $this->registeredBy = $registeredBy;

        return $this;
    }

    #[ORM\PrePersist]
    public function setDefaultRequestedAt()
    {
        $this->requestedAt = new DateTimeImmutable();
    }

    /**
     * @return Collection<int, StudentCourseEndedChapter>
     */
    public function getEndedChapters(): Collection
    {
        return $this->endedChapters;
    }

    public function addEndedChapter(StudentCourseEndedChapter $endedChapter): static
    {
        if (!$this->endedChapters->contains($endedChapter)) {
            $this->endedChapters->add($endedChapter);
            $endedChapter->setStudentCourse($this);
        }

        return $this;
    }

    public function removeEndedChapter(StudentCourseEndedChapter $endedChapter): static
    {
        if ($this->endedChapters->removeElement($endedChapter)) {
            // set the owning side to null (unless already changed)
            if ($endedChapter->getStudentCourse() === $this) {
                $endedChapter->setStudentCourse(null);
            }
        }

        return $this;
    }
}
