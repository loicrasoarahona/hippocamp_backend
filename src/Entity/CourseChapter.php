<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CourseChapterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CourseChapterRepository::class)]
#[ApiResource(
    order: ['yIndex' => 'ASC']
)]
class CourseChapter
{
    #[Groups(['course:item'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['course:item'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    private ?CoursePage $page = null;

    #[ORM\ManyToOne(inversedBy: 'courseChapters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CoursePart $coursePart = null;

    #[Groups(['course:item'])]
    #[ORM\Column(nullable: true)]
    private ?int $yIndex = null;

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

    public function getPage(): ?CoursePage
    {
        return $this->page;
    }

    public function setPage(?CoursePage $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getCoursePart(): ?CoursePart
    {
        return $this->coursePart;
    }

    public function setCoursePart(?CoursePart $coursePart): static
    {
        $this->coursePart = $coursePart;

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
}
