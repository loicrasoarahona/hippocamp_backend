<?php

namespace App\CustomFilters;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;

class StudentByCourseNameFilter extends AbstractFilter
{

    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        if ($property != 'courseName') {
            return;
        }

        if (!$value) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];


        // On fait un LEFT JOIN avec l’entité imbriquée
        $queryBuilder
            ->leftJoin(sprintf('%s.studentCourses', $alias), 'studentCourse')
            ->join('studentCourse.course', 'course')
            ->andWhere('LOWER(course.name) LIKE LOWER(:courseName)')
            ->andWhere('studentCourse.registeredAt IS NOT null')
            ->setParameter('courseName', '%' . $value . '%');
    }

    public function getDescription(string $resourceClass): array
    {
        return ([
            'courseName' => [
                'property' => 'courseName',
                'required' => false,
                'description' => 'Filtre les étudiants par le nom de cours'
            ]
        ]);
    }
}
