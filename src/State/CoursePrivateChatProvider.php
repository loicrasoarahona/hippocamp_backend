<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\CoursePrivateChat;
use App\Service\CoursePrivateChatService;
use Doctrine\ORM\EntityManagerInterface;

class CoursePrivateChatProvider implements ProviderInterface
{
    public function __construct(private EntityManagerInterface $em, private CollectionProvider $collectionProvider, private CoursePrivateChatService $coursePrivateChatService) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof GetCollection) {

            // On délègue à l’implémentation officielle qui gère filtres/pagination/sorting
            $chats = $this->collectionProvider->provide($operation, $uriVariables, $context);

            foreach ($chats as $chat) {
                $lastMessage = $this->coursePrivateChatService->findLastMessage($chat->getId());
                $chat->lastMessage = $lastMessage;
            }

            return $chats;
        }

        return null;
    }
}
