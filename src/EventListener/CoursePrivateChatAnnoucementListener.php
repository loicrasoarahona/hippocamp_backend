<?php

namespace App\EventListener;

use App\Entity\CoursePrivateChatAnnouncement;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: CoursePrivateChatAnnouncement::class)]
class CoursePrivateChatAnnouncementListener
{

    public function __construct(private EntityManagerInterface $em) {}

    public function postPersist(CoursePrivateChatAnnouncement $cpca, PostPersistEventArgs $args)
    {
        // assigner last annoncement dans le chat
        $chat = $cpca->getChat();
        $chat->setLastAnnouncement($cpca);
        $this->em->persist($chat);
        $this->em->flush();
    }
}
