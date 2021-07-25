<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Service;

use App\Ticket\Filter\Entity\FilterItem;
use App\Ticket\Filter\FilterList;

/**
 * Class FilterListService
 *
 * Класс для создания списка фильтров
 *
 * @package App\Ticket\Filter\Service
 */
final class FilterListService
{
    private FilterList $filterList;

    public function __construct(FilterList $filterList)
    {
        $this->filterList = $filterList;
    }

    /**
     * Вывести список фильтров из сырого массива
     *
     * @param array|null $rawArray
     *
     * @return FilterList|null
     */
    public function getFilterListOfRaw(?array $rawArray): ?FilterList
    {
        if (null === $rawArray) {
            return null;
        }

        $filterItems = [];
        foreach ($rawArray as $item) {
            $filter = FilterFactoryService::initFilter(FilterItem::fromState($item));
            $filterItems[] = $filter;
        }

        return $this->filterList->setFilterFields($filterItems);
    }
}
