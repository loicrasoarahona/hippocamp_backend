<?php

namespace App\Entity;

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
use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[ApiFilter(CaseInsensitiveSearchFilter::class, properties: ["name"])]
#[ApiFilter(SearchFilter::class, properties: ['categories' => 'exact'])]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['course:collection', 'courseCategory:collection']]),
        new Get(normalizationContext: ['groups' => ['course:item']]),
        new Post(),
        new Put(denormalizationContext: ['groups' => ['course:item']]),
        new Patch(denormalizationContext: ['groups' => ['course:item']]),
        new Delete()
    ]
)]
class Course
{
    #[Groups(['course:collection', 'course:item'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['course:collection', 'course:item'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['course:collection', 'course:item'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateStart = null;

    #[Groups(['course:collection', 'course:item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $defaultLocation = null;

    #[Groups(['course:collection', 'course:item'])]
    /**
     * @var Collection<int, Teacher>
     */
    #[ORM\ManyToMany(targetEntity: Teacher::class, inversedBy: 'courses')]
    private Collection $teachers;

    #[Groups(['course:collection', 'course:item'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups(['course:collection', 'course:item'])]
    /**
     * @var Collection<int, CourseCategory>
     */
    #[ORM\ManyToMany(targetEntity: CourseCategory::class, inversedBy: 'courses')]
    private Collection $categories;

    #[Groups(['course:collection', 'course:item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $duration = null;

    #[Groups(['course:collection', 'course:item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Groups(['course:collection', 'course:item'])]
    #[ORM\ManyToOne]
    private ?CoursePage $welcomePage = null;

    #[Groups(['course:collection', 'course:item'])]
    /**
     * @var Collection<int, CourseEvent>
     */
    #[ORM\OneToMany(targetEntity: CourseEvent::class, mappedBy: 'course', orphanRemoval: true)]
    private Collection $courseEvents;

    #[Groups(['course:item'])]
    /**
     * @var Collection<int, CoursePart>
     */
    #[ORM\OneToMany(targetEntity: CoursePart::class, mappedBy: 'course', orphanRemoval: true, cascade: ['persist'])]
    #[ORM\OrderBy(['yIndex' => 'ASC'])]
    private Collection $courseParts;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->courseEvents = new ArrayCollection();
        $this->courseParts = new ArrayCollection();
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

    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTime $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDefaultLocation(): ?string
    {
        return $this->defaultLocation;
    }

    public function setDefaultLocation(?string $defaultLocation): static
    {
        $this->defaultLocation = $defaultLocation;

        return $this;
    }

    /**
     * @return Collection<int, Teacher>
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): static
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers->add($teacher);
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): static
    {
        $this->teachers->removeElement($teacher);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, CourseCategory>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(CourseCategory $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(CourseCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getWelcomePage(): ?CoursePage
    {
        return $this->welcomePage;
    }

    public function setWelcomePage(?CoursePage $welcomePage): static
    {
        $this->welcomePage = $welcomePage;

        return $this;
    }

    /**
     * @return Collection<int, CourseEvent>
     */
    public function getCourseEvents(): Collection
    {
        return $this->courseEvents;
    }

    public function addCourseEvent(CourseEvent $courseEvent): static
    {
        if (!$this->courseEvents->contains($courseEvent)) {
            $this->courseEvents->add($courseEvent);
            $courseEvent->setCourse($this);
        }

        return $this;
    }

    public function removeCourseEvent(CourseEvent $courseEvent): static
    {
        if ($this->courseEvents->removeElement($courseEvent)) {
            // set the owning side to null (unless already changed)
            if ($courseEvent->getCourse() === $this) {
                $courseEvent->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CoursePart>
     */
    public function getCourseParts(): Collection
    {
        return $this->courseParts;
    }

    public function addCoursePart(CoursePart $coursePart): static
    {
        if (!$this->courseParts->contains($coursePart)) {
            $this->courseParts->add($coursePart);
            $coursePart->setCourse($this);
        }

        return $this;
    }

    public function removeCoursePart(CoursePart $coursePart): static
    {
        if ($this->courseParts->removeElement($coursePart)) {
            // set the owning side to null (unless already changed)
            if ($coursePart->getCourse() === $this) {
                $coursePart->setCourse(null);
            }
        }

        return $this;
    }
}
