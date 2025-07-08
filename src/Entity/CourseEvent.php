<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CourseEventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CourseEventRepository::class)]
#[ApiResource]
class CourseEvent
{
    #[Groups(['course:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['course:collection'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['course:collection'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[Groups(['course:collection'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CourseEventType $type = null;

    #[ORM\ManyToOne(inversedBy: 'courseEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[Groups(['course:collection'])]
    #[ORM\Column]
    private ?\DateTime $startDate = null;

    #[Groups(['course:collection'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTime $endDate = null;

    #[Groups(['course:collection'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getType(): ?CourseEventType
    {
        return $this->type;
    }

    public function setType(?CourseEventType $type): static
    {
        $this->type = $type;

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

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): static
    {
        $this->endDate = $endDate;

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
}
