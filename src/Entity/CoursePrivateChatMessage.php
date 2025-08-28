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
use App\Repository\CoursePrivateChatMessageRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CoursePrivateChatMessageRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['coursePrivateChatMessage:collection']]),
        new Get(),
        new Post(normalizationContext: ['groups' => ['coursePrivateChatMessage:collection']]),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['chat' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['timestamp'])]
class CoursePrivateChatMessage
{

    #[Groups(['coursePrivateChatMessage:collection', 'coursePrivateChat:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['coursePrivateChatMessage:collection', 'coursePrivateChat:collection'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups(['coursePrivateChatMessage:collection', 'coursePrivateChat:collection'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MessageType $type = null;

    #[Groups(['coursePrivateChatMessage:collection', 'coursePrivateChat:collection'])]
    #[ORM\Column]
    private ?\DateTime $timestamp = null;

    #[Groups(['coursePrivateChatMessage:collection'])]
    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CoursePrivateChat $chat = null;

    #[Groups(['coursePrivateChatMessage:collection', 'coursePrivateChat:collection'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $m_user = null;

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

    public function getType(): ?MessageType
    {
        return $this->type;
    }

    public function setType(?MessageType $type): static
    {
        $this->type = $type;

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

    public function getChat(): ?CoursePrivateChat
    {
        return $this->chat;
    }

    public function setChat(?CoursePrivateChat $chat): static
    {
        $this->chat = $chat;

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
}
