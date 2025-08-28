<?php

namespace App\EventListener;

use App\Entity\CoursePrivateChatMessage;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: CoursePrivateChatMessage::class)]
class CoursePrivateChatMessageListener
{

    public function __construct(private EntityManagerInterface $em) {}

    public function postPersist(CoursePrivateChatMessage $cpcm, PostPersistEventArgs $args)
    {
        // assigner last message dans le chat
        $chat = $cpcm->getChat();
        $chat->setLastMessage($cpcm);
        $this->em->persist($chat);
        $this->em->flush();
    }
}
