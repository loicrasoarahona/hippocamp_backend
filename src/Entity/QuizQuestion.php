<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\QuizQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuizQuestionRepository::class)]
#[ApiResource]
class QuizQuestion
{
    #[Groups(["quizQuestion:collection", "quiz:item"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["quizQuestion:collection"])]
    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[Groups(["quizQuestion:collection", "quiz:item"])]
    #[ORM\Column(nullable: true)]
    private ?int $index = null;

    #[Groups(["quizQuestion:collection", "quiz:item"])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups(["quizQuestion:collection", "quiz:item"])]
    /**
     * @var Collection<int, QuizQuestionOption>
     */
    #[ORM\OneToMany(targetEntity: QuizQuestionOption::class, mappedBy: 'question', orphanRemoval: true, cascade: ["persist"])]
    private Collection $options;

    #[Groups(["quizQuestion:collection", "quiz:item"])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $explanation = null;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getIndex(): ?int
    {
        return $this->index;
    }

    public function setIndex(?int $index): static
    {
        $this->index = $index;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, QuizQuestionOption>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(QuizQuestionOption $option): static
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
            $option->setQuestion($this);
        }

        return $this;
    }

    public function removeOption(QuizQuestionOption $option): static
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getQuestion() === $this) {
                $option->setQuestion(null);
            }
        }

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(?string $explanation): static
    {
        $this->explanation = $explanation;

        return $this;
    }
}
