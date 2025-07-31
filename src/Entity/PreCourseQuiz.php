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
use App\Repository\PreCourseQuizRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PreCourseQuizRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['course' => 'exact'])]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['preCourseQuiz:collection']]),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
class PreCourseQuiz
{
    #[Groups(['preCourseQuiz:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['preCourseQuiz:collection'])]
    #[ORM\ManyToOne(inversedBy: 'preCourseQuizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[Groups(['preCourseQuiz:collection'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[Groups(['preCourseQuiz:collection'])]
    #[ORM\ManyToOne]
    private ?CoursePart $coursePartSuggestion = null;

    #[Groups(['preCourseQuiz:collection'])]
    #[ORM\Column]
    private ?float $passingScore = null;


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

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getCoursePartSuggestion(): ?CoursePart
    {
        return $this->coursePartSuggestion;
    }

    public function setCoursePartSuggestion(?CoursePart $coursePartSuggestion): static
    {
        $this->coursePartSuggestion = $coursePartSuggestion;

        return $this;
    }

    public function getPassingScore(): ?float
    {
        return $this->passingScore;
    }

    public function setPassingScore(float $passingScore): static
    {
        $this->passingScore = $passingScore;

        return $this;
    }
}
