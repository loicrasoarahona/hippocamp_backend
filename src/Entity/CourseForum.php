<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CourseForumRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CourseForumRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(denormalizationContext: ['groups' => ['courseForum:item']]),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
class CourseForum
{
    #[Groups(['courseForum:item'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['courseForum:item'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $subject = null;

    #[Groups(['courseForum:item'])]
    #[ORM\Column]
    private ?\DateTime $timestamp = null;

    #[Groups(['courseForum:item'])]
    #[ORM\ManyToOne(inversedBy: 'forums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[Groups(['courseForum:item'])]
    #[ORM\ManyToOne(inversedBy: 'courseForums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $m_user = null;

    #[Groups(['courseForum:item'])]
    /**
     * @var Collection<int, CourseForumReply>
     */
    #[ORM\OneToMany(targetEntity: CourseForumReply::class, mappedBy: 'forum', orphanRemoval: true, cascade: ['persist'])]
    private Collection $replies;

    #[ORM\PrePersist]
    public function setDefaultTimestamp()
    {
        $this->timestamp = new DateTime();
    }

    public function __construct()
    {
        $this->replies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTime $timestamp): static
    {
        $this->timestamp = $timestamp;

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

    public function getMUser(): ?User
    {
        return $this->m_user;
    }

    public function setMUser(?User $m_user): static
    {
        $this->m_user = $m_user;

        return $this;
    }

    /**
     * @return Collection<int, CourseForumReply>
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(CourseForumReply $reply): static
    {
        if (!$this->replies->contains($reply)) {
            $this->replies->add($reply);
            $reply->setForum($this);
        }

        return $this;
    }

    public function removeReply(CourseForumReply $reply): static
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getForum() === $this) {
                $reply->setForum(null);
            }
        }

        return $this;
    }
}
