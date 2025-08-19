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
use App\Repository\QuizRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
#[ApiResource(operations: [
    new GetCollection(),
    new Get(normalizationContext: ["groups" => ["quiz:item"]]),
    new Post(denormalizationContext: ["groups" => ["quiz:collection", "quizQuestion:collection", "quizQuestionOption:collection"]]),
    new Put(),
    new Patch(),
    new Delete()
])]
#[ApiFilter(SearchFilter::class, properties: ['course' => 'exact'])]
#[ORM\HasLifecycleCallbacks]
class Quiz
{
    #[Groups(['quiz:collection', "quiz:item", 'preCourseQuiz:collection', 'quizAnswer:item', 'quizAnswer:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['quiz:collection', "quiz:item", 'preCourseQuiz:collection', 'quizAnswer:item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Groups(['quiz:collection', "quiz:item", 'preCourseQuiz:collection', 'quizAnswer:item'])]
    /**
     * @var Collection<int, QuizQuestion>
     */
    #[ORM\OneToMany(targetEntity: QuizQuestion::class, mappedBy: 'quiz', orphanRemoval: true, cascade: ["persist"])]
    private Collection $questions;

    #[Groups(['preCourseQuiz:collection', 'quizAnswer:item'])]
    #[ORM\ManyToOne(inversedBy: 'quizzes')]
    private ?Course $course = null;

    #[Groups(['preCourseQuiz:collection', 'quizAnswer:item'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['preCourseQuiz:collection', 'quiz:collection', 'quiz:item', 'quizAnswer:item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\PrePersist]
    public function setDefaultCreatedAt()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, QuizQuestion>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(QuizQuestion $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(QuizQuestion $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
