<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Specification;

/**
 * Interface SpecificationInterface
 *
 * Интерфейс спецификации
 *
 * @package App\Ticket\Modules\TypeRegistration\Specification
 */
interface SpecificationInterface
{
    /**
     * Проверка условий спецификаций
     *
     * @param SpecificationEntity $entity
     *
     * @return bool
     */
    public function isSatisfiedBy(SpecificationEntity $entity): bool;
}
