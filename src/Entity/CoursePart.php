<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CoursePartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CoursePartRepository::class)]
#[ApiResource(
    order: ['yIndex' => 'ASC'],
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(denormalizationContext: ['groups' => ['course:item']]),
        new Patch(),
        new Delete()
    ]
)]
class CoursePart
{
    #[Groups(['course:item', 'courseChapter:item'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['course:item', 'courseChapter:item'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[Groups(['courseChapter:item'])]
    #[ORM\ManyToOne(inversedBy: 'courseParts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[Groups(['course:item', 'courseChapter:item'])]
    #[ORM\Column(nullable: true)]
    private ?int $yIndex = null;

    #[Groups(['course:item'])]
    /**
     * @var Collection<int, CourseChapter>
     */
    #[ORM\OneToMany(targetEntity: CourseChapter::class, mappedBy: 'coursePart', orphanRemoval: true, cascade: ['persist'])]
    #[ORM\OrderBy(['yIndex' => 'ASC'])]
    private Collection $courseChapters;

    public function __construct()
    {
        $this->courseChapters = new ArrayCollection();
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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getYIndex(): ?int
    {
        return $this->yIndex;
    }

    public function setYIndex(?int $yIndex): static
    {
        $this->yIndex = $yIndex;

        return $this;
    }

    /**
     * @return Collection<int, CourseChapter>
     */
    public function getCourseChapters(): Collection
    {
        return $this->courseChapters;
    }

    public function addCourseChapter(CourseChapter $courseChapter): static
    {
        if (!$this->courseChapters->contains($courseChapter)) {
            $this->courseChapters->add($courseChapter);
            $courseChapter->setCoursePart($this);
        }

        return $this;
    }

    public function removeCourseChapter(CourseChapter $courseChapter): static
    {
        if ($this->courseChapters->removeElement($courseChapter)) {
            // set the owning side to null (unless already changed)
            if ($courseChapter->getCoursePart() === $this) {
                $courseChapter->setCoursePart(null);
            }
        }

        return $this;
    }
}
