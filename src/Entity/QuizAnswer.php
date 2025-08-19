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
use App\Repository\QuizAnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuizAnswerRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['m_user' => 'exact', 'quiz' => 'exact'])]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['quizAnswer:collection']]),
        new Get(),
        new Post(denormalizationContext: ['groups' => ['quizAnswer:item']]),
        new Put(denormalizationContext: ['groups' => ['quizAnswer:item']]),
        new Patch(),
        new Delete()
    ]
)]
class QuizAnswer
{
    #[Groups(['quizAnswer:item', 'quizAnswer:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['quizAnswer:item', 'quizAnswer:collection'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $m_user = null;

    #[Groups(['quizAnswer:item', 'quizAnswer:collection'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[Groups(['quizAnswer:item', 'quizAnswer:collection'])]
    #[ORM\Column(nullable: true)]
    private ?float $score = null;

    #[Groups(['quizAnswer:item', 'quizAnswer:collection'])]
    /**
     * @var Collection<int, QuizQuestionOption>
     */
    #[ORM\ManyToMany(targetEntity: QuizQuestionOption::class)]
    private Collection $chosenOptions;

    public function __construct()
    {
        $this->chosenOptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMUser(): ?User
    {
        return $this->m_user;
    }

    public function setMUser(?User $m_user): static
    {
        $this->m_user = $m_user;

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

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): static
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return Collection<int, QuizQuestionOption>
     */
    public function getChosenOptions(): Collection
    {
        return $this->chosenOptions;
    }

    public function addChosenOption(QuizQuestionOption $chosenOption): static
    {
        if (!$this->chosenOptions->contains($chosenOption)) {
            $this->chosenOptions->add($chosenOption);
        }

        return $this;
    }

    public function removeChosenOption(QuizQuestionOption $chosenOption): static
    {
        $this->chosenOptions->removeElement($chosenOption);

        return $this;
    }
}
