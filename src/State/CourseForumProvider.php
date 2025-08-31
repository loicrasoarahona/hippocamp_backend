<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\CourseForumService;

class CourseForumProvider implements ProviderInterface
{

    public function __construct(
        private CollectionProvider $collectionProvider,
        private CourseForumService $courseForumService,
        private ItemProvider $itemProvider
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof GetCollection) {
            // On délègue à l’implémentation officielle qui gère filtres/pagination/sorting
            $forums = $this->collectionProvider->provide($operation, $uriVariables, $context);

            foreach ($forums as $forum) {
                $forum->displayName = $this->courseForumService->getDisplayName($forum);
                $forum->nbReplies = $this->courseForumService->getNbReplies($forum);
            }

            return $forums;
        }

        if ($operation instanceof Get) {
            // Ici on est sur un GET "item"
            // On délègue au DataProvider par défaut
            // ⚠️ Le plus simple est d’injecter l’ItemProvider officiel de la même manière
            // que tu as injecté CollectionProvider
            // Exemple si tu ajoutes dans le constructeur : private ItemProvider $itemProvider

            $forum = $this->itemProvider->provide($operation, $uriVariables, $context);

            if ($forum) {
                $forum->displayName = $this->courseForumService->getDisplayName($forum);
                $forum->nbReplies = $this->courseForumService->getNbReplies($forum);
            }

            return $forum;
        }

        return null;
    }
}
