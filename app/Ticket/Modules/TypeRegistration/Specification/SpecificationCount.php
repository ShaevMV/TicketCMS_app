<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Specification;

/**
 * Class SpecificationCount
 *
 * Спецификация проверки коллективного билета
 *
 * @package App\Ticket\Modules\TypeRegistration\Specification
 */
final class SpecificationCount implements SpecificationInterface
{
    /**
     * Количество билетов в заказе
     *
     * @var int
     */
    private int $count;

    /**
     * SpecificationCount constructor.
     *
     * @param int $count
     */
    public function __construct(int $count)
    {
        $this->count = $count;
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
        return $entity->getCount() >= $this->count;
    }
}
