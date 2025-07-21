<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\StudentCourseEndedChapterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StudentCourseEndedChapterRepository::class)]
#[ApiResource(
    order: ['id' => 'ASC'],
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['studentCourseEndedChapter:collection']]),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
#[UniqueEntity(fields: ['studentCourse', 'chapter'], message: 'Ce chapitre existe déjà.')]
#[ApiFilter(SearchFilter::class, properties: ['studentCourse.student' => 'exact', 'studentCourse.course' => 'exact'])]
class StudentCourseEndedChapter
{
    #[Groups(['studentCourseEndedChapter:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['studentCourseEndedChapter:collection'])]
    #[ORM\ManyToOne(inversedBy: 'endedChapters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StudentCourse $studentCourse = null;

    #[Groups(['studentCourseEndedChapter:collection'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CourseChapter $chapter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudentCourse(): ?StudentCourse
    {
        return $this->studentCourse;
    }

    public function setStudentCourse(?StudentCourse $studentCourse): static
    {
        $this->studentCourse = $studentCourse;

        return $this;
    }

    public function getChapter(): ?CourseChapter
    {
        return $this->chapter;
    }

    public function setChapter(?CourseChapter $chapter): static
    {
        $this->chapter = $chapter;

        return $this;
    }
}
