<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Specification;

/**
 * Class SpecificationAnd
 *
 * Спецификация типа И
 *
 * @package App\Ticket\Modules\TypeRegistration\Specification
 */
final class SpecificationAnd implements SpecificationInterface
{
    /**
     * Массив спецификаций
     *
     * @var SpecificationInterface[]
     */
    private array $specifications;

    /**
     * @param SpecificationInterface[] $specifications
     */
    public function __construct(array $specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * Проверка условий спецификаций
     *
     * @param SpecificationEntity $entity
     *
     * @return bool
     */
    public function isSatisfiedBy(SpecificationEntity $entity): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($entity)) {
                return false;
            }
        }

        return true;
    }
}
