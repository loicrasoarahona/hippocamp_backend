<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\CourseForumReplyService;

class CourseForumReplyProvider implements ProviderInterface
{

    public function __construct(
        private CollectionProvider $collectionProvider,
        private CourseForumReplyService $courseForumReplyService
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof GetCollection || $operation instanceof Get) {
            // On délègue à l’implémentation officielle qui gère filtres/pagination/sorting
            $replies = $this->collectionProvider->provide($operation, $uriVariables, $context);

            foreach ($replies as $reply) {
                $reply->displayName = $this->courseForumReplyService->getDisplayName($reply);
            }

            return $replies;
        }

        return null;
    }
}
