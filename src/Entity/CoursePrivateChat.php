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
use App\Repository\CoursePrivateChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CoursePrivateChatRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['coursePrivateChat:collection']]),
        new Get(normalizationContext: ['groups' => ['coursePrivateChat:collection']]),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ]
)]
#[UniqueEntity(fields: ['course', 'student'], message: 'Cet utilisateur ne peut pas avoir plusieurs discussions associées à ce cours.')]
#[ApiFilter(SearchFilter::class, properties: ['course' => 'exact', 'student' => 'exact', 'course.teachers' => 'exact', 'student.name' => 'ipartial', 'student.surname' => 'ipartial'])]
class CoursePrivateChat
{
    #[Groups(['coursePrivateChat:collection'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['coursePrivateChat:collection'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[Groups(['coursePrivateChat:collection'])]
    #[ORM\ManyToOne(inversedBy: 'coursePrivateChats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    /**
     * @var Collection<int, CoursePrivateChatMessage>
     */
    #[ORM\OneToMany(targetEntity: CoursePrivateChatMessage::class, mappedBy: 'chat', orphanRemoval: true)]
    private Collection $messages;

    #[Groups(['coursePrivateChat:collection'])]
    #[ORM\ManyToOne]
    private ?CoursePrivateChatMessage $lastMessage = null;

    /**
     * @var Collection<int, CoursePrivateChatAnnouncement>
     */
    #[ORM\OneToMany(targetEntity: CoursePrivateChatAnnouncement::class, mappedBy: 'chat', orphanRemoval: true)]
    private Collection $announcements;

    #[Groups(['coursePrivateChat:collection'])]
    #[ORM\ManyToOne]
    private ?CoursePrivateChatAnnouncement $lastAnnouncement = null;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->announcements = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

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

    /**
     * @return Collection<int, CoursePrivateChatMessage>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(CoursePrivateChatMessage $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setChat($this);
        }

        return $this;
    }

    public function removeMessage(CoursePrivateChatMessage $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getChat() === $this) {
                $message->setChat(null);
            }
        }

        return $this;
    }

    public function getLastMessage(): ?CoursePrivateChatMessage
    {
        return $this->lastMessage;
    }

    public function setLastMessage(?CoursePrivateChatMessage $lastMessage): static
    {
        $this->lastMessage = $lastMessage;

        return $this;
    }

    /**
     * @return Collection<int, CoursePrivateChatAnnouncement>
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(CoursePrivateChatAnnouncement $announcement): static
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements->add($announcement);
            $announcement->setChat($this);
        }

        return $this;
    }

    public function removeAnnouncement(CoursePrivateChatAnnouncement $announcement): static
    {
        if ($this->announcements->removeElement($announcement)) {
            // set the owning side to null (unless already changed)
            if ($announcement->getChat() === $this) {
                $announcement->setChat(null);
            }
        }

        return $this;
    }

    public function getLastAnnouncement(): ?CoursePrivateChatAnnouncement
    {
        return $this->lastAnnouncement;
    }

    public function setLastAnnouncement(?CoursePrivateChatAnnouncement $lastAnnouncement): static
    {
        $this->lastAnnouncement = $lastAnnouncement;

        return $this;
    }
}
