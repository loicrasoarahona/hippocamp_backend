<?php

namespace App\CustomFilters;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;

class StudentByFullNameFilter extends AbstractFilter
{

    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        if ($property != 'fullName') {
            return;
        }

        if (!$value) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];


        $queryBuilder
            ->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like(sprintf('LOWER(%s.name)', $alias), 'LOWER(:fullName)'),
                    $queryBuilder->expr()->like(sprintf('LOWER(%s.surname)', $alias), 'LOWER(:fullName)'),
                )
            )
            ->setParameter('fullName', '%' . $value . '%')
        ;
    }

    public function getDescription(string $resourceClass): array
    {
        return ([
            'fullName' => [
                'property' => 'fullName',
                'required' => false,
                'description' => 'Filtre les étudiants par leur nom complet'
            ]
        ]);
    }
}
