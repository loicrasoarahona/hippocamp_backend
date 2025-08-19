<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CoursePrivateChatMessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursePrivateChatMessageRepository::class)]
#[ApiResource]
class CoursePrivateChatMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MessageType $type = null;

    #[ORM\Column]
    private ?\DateTime $timestamp = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CoursePrivateChat $chat = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $m_user = null;

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
