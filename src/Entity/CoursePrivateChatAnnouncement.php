<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CoursePrivateChatAnnouncementRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CoursePrivateChatAnnouncementRepository::class)]
#[ApiResource]
class CoursePrivateChatAnnouncement
{
    #[Groups(['coursePrivateChat:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'announcements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CoursePrivateChat $chat = null;

    #[Groups(['coursePrivateChat:collection'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups(['coursePrivateChat:collection'])]
    #[ORM\Column]
    private ?\DateTime $timestamp = null;

    #[ORM\PrePersist]
    public function setDefaultTimestamp()
    {
        $this->timestamp = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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
}
