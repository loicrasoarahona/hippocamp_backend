<?php
// api/src/Filter/RegexpFilter.php

namespace App\CustomFilters;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;
use ApiPlatform\OpenApi\Model\Parameter;

final class CaseInsensitiveSearchFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        // Otherwise filter is applied to order and page as well
        if (
            !$this->isPropertyEnabled($property, $resourceClass) ||
            !$this->isPropertyMapped($property, $resourceClass)
        ) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];

        $parameterName = $queryNameGenerator->generateParameterName($property); // Generate a unique parameter name to avoid collisions with other filters
        $queryBuilder
            ->orWhere(sprintf('LOWER(%s.%s) LIKE LOWER(:%s)', $rootAlias, $property, $parameterName))
            ->setParameter($parameterName, "%" . $value . "%");
    }

    // This function is only used to hook in documentation generators (supported by Swagger and Hydra)
    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description["regexp_$property"] = [
                'property' => $property,
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'description' => 'Filter using a regex. This will appear in the OpenApi documentation!',
                'openapi' => new Parameter(
                    name: $property,
                    in: 'query',
                    allowEmptyValue: true,
                    explode: false, // to be true, the type must be Type::BUILTIN_TYPE_ARRAY, ?product=blue,green will be ?product=blue&product=green
                    allowReserved: false, // if true, query parameters will be not percent-encoded
                    example: 'Custom example that will be in the documentation and be the default value of the sandbox',
                ),
            ];
        }

        return $description;
    }
}
