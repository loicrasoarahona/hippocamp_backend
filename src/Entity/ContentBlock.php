<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ContentBlockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContentBlockRepository::class)]
#[ApiResource]
class ContentBlock
{
    #[Groups(['coursePage:create', 'coursePage:read', 'course:item', 'courseChapter:item'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['coursePage:create', 'coursePage:read', 'course:item', 'courseChapter:item'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ContentBlockType $type = null;

    #[Groups(['coursePage:create', 'coursePage:read', 'course:item', 'courseChapter:item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[Groups(['coursePage:create', 'coursePage:read', 'course:item', 'courseChapter:item'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups(['coursePage:create', 'coursePage:read', 'course:item', 'courseChapter:item'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Groups(['coursePage:create', 'coursePage:read', 'course:item', 'courseChapter:item'])]
    #[ORM\Column(nullable: true)]
    private ?int $yIndex = null;

    #[ORM\ManyToOne(inversedBy: 'contentBlocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CoursePage $coursePage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?ContentBlockType
    {
        return $this->type;
    }

    public function setType(?ContentBlockType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getCoursePage(): ?CoursePage
    {
        return $this->coursePage;
    }

    public function setCoursePage(?CoursePage $coursePage): static
    {
        $this->coursePage = $coursePage;

        return $this;
    }
}
