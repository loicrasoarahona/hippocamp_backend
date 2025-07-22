<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\QuizQuestionOptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuizQuestionOptionRepository::class)]
#[ApiResource]
class QuizQuestionOption
{
    #[Groups(["quizQuestionOption:collection", "quiz:item"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["quizQuestionOption:collection"])]
    #[ORM\ManyToOne(inversedBy: 'options')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuizQuestion $question = null;

    #[Groups(["quizQuestionOption:collection", "quiz:item"])]
    #[ORM\Column(nullable: true)]
    private ?int $index = null;

    #[Groups(["quizQuestionOption:collection", "quiz:item"])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups(["quizQuestionOption:collection", "quiz:item"])]
    #[ORM\Column]
    private ?bool $correct = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?QuizQuestion
    {
        return $this->question;
    }

    public function setQuestion(?QuizQuestion $question): static
    {
        $this->question = $question;

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

    public function isCorrect(): ?bool
    {
        return $this->correct;
    }

    public function setCorrect(bool $correct): static
    {
        $this->correct = $correct;

        return $this;
    }
}
