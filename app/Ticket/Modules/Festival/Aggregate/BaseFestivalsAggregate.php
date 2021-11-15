<?php

namespace App\Ticket\Modules\Festival\Aggregate;

use App\Ticket\Filter\FilterList;
use App\Ticket\Modules\Festival\Dto\FestivalRawDto;
use App\Ticket\Modules\Festival\Entity\Festival;
use App\Ticket\Modules\Festival\Repository\FestivalRepository;
use App\Ticket\Modules\Festival\Service\FestivalService;
use App\Ticket\Pagination\Pagination;
use Exception;
use Webpatser\Uuid\Uuid;

class BaseFestivalsAggregate
{
    private FestivalRepository $festivalRepository;
    private FestivalService $festivalService;

    public function __construct(
        FestivalRepository $festivalRepository,
        FestivalService    $festivalService
    ) {
        $this->festivalRepository = $festivalRepository;
        $this->festivalService = $festivalService;
    }

    /**
     * Создать фестиваль
     *
     * @throws Exception
     */
    public function createFestival(FestivalRawDto $festivalRawDto): FestivalAggregate
    {
        $id = $this->festivalRepository->create($festivalRawDto);
        $festival = Festival::fromRawState($id, $festivalRawDto);

        return FestivalAggregate::init($festival);
    }

    /**
     * Получить активный фестиваль
     */
    public function getActive(): ?FestivalAggregate
    {
        $festival = $this->festivalRepository->getActive();

        return FestivalAggregate::init($festival);
    }

    /**
     * Получить фестиваль по его id
     */
    public function get(Uuid $id): FestivalAggregate
    {
        /** @var Festival $festival */
        $festival = $this->festivalRepository->findById($id);

        return FestivalAggregate::init($festival);
    }

    /**
     * Вывести список фестивалей
     *
     * @return FestivalAggregate[]|null
     */
    public function getList(?Pagination $pagination = null, ?FilterList $filterList = null): ?array
    {
        /** @var Festival[]|null $festivalEntityList */
        $festivalEntityList = $this->festivalService->getList($pagination, $filterList);

        if (null === $festivalEntityList) {
            return null;
        }

        $result = [];
        foreach ($festivalEntityList as $item) {
            $result[] = FestivalAggregate::init($item);
        }

        return $result;
    }
}
