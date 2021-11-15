<?php

namespace App\Ticket\Modules\Festival\Aggregate;

use App\Ticket\Modules\Festival\Entity\Festival;
use App\Ticket\Modules\Festival\Repository\FestivalRepository;
use Exception;
use Illuminate\Support\Facades\App;

class FestivalAggregate
{
    private Festival $festival;
    private FestivalRepository $festivalRepository;

    private function __construct(Festival $festival)
    {
        $this->festival = $festival;
        $this->festivalRepository = App::make(FestivalRepository::class);
    }

    public static function init(Festival $festival): self
    {
        return new self($festival);
    }

    public function getFestival(): array
    {
        return $this->festival->toArray();
    }

    /**
     * Сменить активность у фестиваля
     * @throws Exception
     */
    public function changeActivity(): self
    {
        $this->festival->getStatus()->changeActive();

        $this->festivalRepository->update($this->festival->getId(), $this->festival);

        return $this;
    }
}
