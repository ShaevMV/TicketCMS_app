<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Festival\Entity;

use App\Ticket\Date\DateBetween;
use App\Ticket\Entity\AbstractionEntity;
use App\Ticket\Modules\Festival\Dto\FestivalRawDto;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use Webpatser\Uuid\Uuid;

/**
 * Class Festival
 *
 * Сущность фестиваля
 *
 * @package App\Ticket\Festival\Entity
 */
final class Festival extends AbstractionEntity
{
    /**
     * Идентификатор
     *
     * @var Uuid
     */
    protected Uuid $id;

    /**
     * Статус
     *
     * @var FestivalStatus
     */
    protected FestivalStatus $status;

    /**
     * Заголовок - названия
     *
     * @var string
     */
    protected string $title;

    /**
     * Даты проведения
     *
     * @var DateBetween
     */
    protected DateBetween $date;

    /**
     * Описание
     *
     * @var string|null
     */
    protected ?string $description;

    /**
     * Типы билетов
     *
     * @var TypeRegistration[]|null
     */
    protected ?array $typeRegistration;

    public static function fromState(array $data): self
    {
        return (new self())
            ->setId(Uuid::import($data['id']))
            ->setTitle($data['title'])
            ->setDescription($data['description'])
            ->setDate(DateBetween::fromState($data))
            ->setStatus(FestivalStatus::fromInt($data['status']));
    }

    public static function fromRawState(Uuid $uuid, FestivalRawDto $festivalRawDto): self
    {
        return (new self())
            ->setId($uuid)
            ->setTitle($festivalRawDto->getTitle())
            ->setDescription($festivalRawDto->getDescription())
            ->setDate($festivalRawDto->getDate())
            ->setStatus($festivalRawDto->getStatus());
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     *
     * @return Festival
     */
    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return FestivalStatus
     */
    public function getStatus(): FestivalStatus
    {
        return $this->status;
    }

    /**
     * @param FestivalStatus $status
     *
     * @return self
     */
    public function setStatus(FestivalStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return TypeRegistration[]
     */
    public function getTypeRegistration(): ?array
    {
        return $this->typeRegistration;
    }

    /**
     * @param TypeRegistration[] $typeRegistration
     *
     * @return self
     */
    public function setTypeRegistration(array $typeRegistration): Festival
    {
        $this->typeRegistration = $typeRegistration;

        return $this;
    }

    /**
     * @return DateBetween
     */
    public function getDate(): DateBetween
    {
        return $this->date;
    }

    /**
     * @param DateBetween $date
     *
     * @return self
     */
    public function setDate(DateBetween $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
