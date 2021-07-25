<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Service;

use App\Ticket\Filter\Service\Factory\FilterFieldsAbstract;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FilterService
 *
 * Сервис для работы с фильтром в базе
 *
 * @package App\Ticket\Filter\Service
 */
final class FilterService
{
    /**
     * Вывести функцию для фильтрации
     *
     * @param FilterFieldsAbstract $filterFieldsAbstract
     *
     * @return Closure|null
     */
    public function getWhere(FilterFieldsAbstract $filterFieldsAbstract): ?Closure
    {
        return function (Builder $builder) use ($filterFieldsAbstract) {
            $builder->where(
                $filterFieldsAbstract->getFilterItem()->getField(),
                $filterFieldsAbstract->getFilterItem()->getOperation(),
                $filterFieldsAbstract->getFilterItem()->getValue()
            );
        };
    }
}
