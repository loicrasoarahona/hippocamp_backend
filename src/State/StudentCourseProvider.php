<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\Operation;
use App\Service\StudentCourseService;

class StudentCourseProvider implements ProviderInterface
{

    public function __construct(
        private CollectionProvider $collectionProvider,
        private StudentCourseService $studentCourseService
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {

        if ($operation instanceof GetCollection) {

            $rows = $this->collectionProvider->provide($operation, $uriVariables, $context);

            foreach ($rows as $studentCourse) {
                $this->studentCourseService->createDefaultChat($studentCourse);
            }

            return $rows;
        }

        return null;
    }
}
