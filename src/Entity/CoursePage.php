<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CoursePageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CoursePageRepository::class)]
#[ApiResource(operations: [
    new GetCollection(),
    new Get(normalizationContext: ["groups" => ["coursePage:read"]]),
    new Post(denormalizationContext: ["groups" => ["coursePage:create"]]),
    new Put(),
    new Delete()
])]
class CoursePage
{
    #[Groups(['coursePage:create', 'coursePage:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['coursePage:create', 'coursePage:read'])]
    /**
     * @var Collection<int, ContentBlock>
     */
    #[ORM\OneToMany(targetEntity: ContentBlock::class, mappedBy: 'coursePage', orphanRemoval: true, cascade: ['persist'])]
    private Collection $contentBlocks;

    public function __construct()
    {
        $this->contentBlocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ContentBlock>
     */
    public function getContentBlocks(): Collection
    {
        return $this->contentBlocks;
    }

    public function addContentBlock(ContentBlock $contentBlock): static
    {
        if (!$this->contentBlocks->contains($contentBlock)) {
            $this->contentBlocks->add($contentBlock);
            $contentBlock->setCoursePage($this);
        }

        return $this;
    }

    public function removeContentBlock(ContentBlock $contentBlock): static
    {
        if ($this->contentBlocks->removeElement($contentBlock)) {
            // set the owning side to null (unless already changed)
            if ($contentBlock->getCoursePage() === $this) {
                $contentBlock->setCoursePage(null);
            }
        }

        return $this;
    }
}
