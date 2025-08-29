<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CourseForumReplyRepository;
use App\State\CourseForumReplyProvider;
use App\Type\DisplayName;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CourseForumReplyRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(provider: CourseForumReplyProvider::class),
        new Get(provider: CourseForumReplyProvider::class),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['timestamp'])]
#[ApiFilter(SearchFilter::class, properties: ['forum' => 'exact'])]
class CourseForumReply
{
    #[Groups(['courseForum:item'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['courseForum:item'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups(['courseForum:item'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $m_user = null;

    #[Groups(['courseForum:item'])]
    #[ORM\Column]
    private ?\DateTime $timestamp = null;

    #[ORM\ManyToOne(inversedBy: 'replies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CourseForum $forum = null;

    public ?DisplayName $displayName;

    #[ORM\PrePersist]
    public function setDefaultTimestamp()
    {
        $this->timestamp = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMUser(): ?User
    {
        return $this->m_user;
    }

    public function setMUser(?User $m_user): static
    {
        $this->m_user = $m_user;

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

    public function getForum(): ?CourseForum
    {
        return $this->forum;
    }

    public function setForum(?CourseForum $forum): static
    {
        $this->forum = $forum;

        return $this;
    }
}
