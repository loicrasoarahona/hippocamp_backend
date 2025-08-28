<?php

namespace App\Service;

use App\Entity\CoursePrivateChatMessage;
use Doctrine\ORM\EntityManagerInterface;

class CoursePrivateChatService
{

    public function __construct(private EntityManagerInterface $em) {}

    public function findLastMessage(int $chatId)
    {
        $tab = $this->em->getRepository(CoursePrivateChatMessage::class)->createQueryBuilder('message')
            ->select()
            ->where('message.chat=:chatId')
            ->setParameter('chatId', $chatId)
            ->addOrderBy('message.timestamp', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if (!empty($tab)) {
            return $tab[0];
        }

        return null;
    }
}
