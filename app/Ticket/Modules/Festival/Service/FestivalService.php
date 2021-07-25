<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Festival\Service;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Filter\FilterList;
use App\Ticket\Modules\Festival\Repository\FestivalRepository;
use App\Ticket\Pagination\Pagination;

final class FestivalService
{
    private FestivalRepository $festivalRepository;

    public function __construct(FestivalRepository $festivalRepository)
    {
        $this->festivalRepository = $festivalRepository;
    }

    /**
     * Выдать общий список фестивалей
     *
     * @param Pagination $pagination
     * @param FilterList|null $filterList
     *
     * @return EntityInterface[]|null
     */
    public function getList(Pagination $pagination, ?FilterList $filterList = null): ?array
    {
        return $this->festivalRepository
            ->setFilter($filterList)
            ->setPagination($pagination)
            ->getList();
    }
}
