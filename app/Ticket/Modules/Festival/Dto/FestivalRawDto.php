<?php

namespace App\Ticket\Modules\Festival\Dto;

use App\Ticket\Date\DateBetween;
use App\Ticket\Entity\AbstractionEntity;
use App\Ticket\Modules\Festival\Entity\FestivalStatus;

class FestivalRawDto extends AbstractionEntity
{
    protected DateBetween $date;
    protected string $description;
    protected FestivalStatus $status;
    protected string $title;

    public function __construct(string $title, string $description, DateBetween $between, FestivalStatus $festivalStatus)
    {
        $this->title = $title;
        $this->date = $between;
        $this->description = $description;
        $this->status = $festivalStatus;
    }

    public static function fromState(array $data): self
    {
        return new self(
            $data['title'],
            $data['description'],
            DateBetween::fromState($data),
            FestivalStatus::fromInt($data['status'])
        );
    }

    public function getDate(): DateBetween
    {
        return $this->date;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): FestivalStatus
    {
        return $this->status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
