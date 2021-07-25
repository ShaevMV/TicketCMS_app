<?php

declare(strict_types=1);

namespace App\Ticket\Modules\PromoCode\Entity;

use App\Ticket\Date\DateBetween;
use App\Ticket\Entity\AbstractionEntity;
use Webpatser\Uuid\Uuid;

/**
 * Class PromoCode
 *
 * сущность промокода
 *
 * @package App\Ticket\Modules\PromoCode\Entity
 */
final class PromoCode extends AbstractionEntity
{
    private const COLUMNS_LIST = [
        'id' => [
            'value' => 'id',
            'type' => self::TYPE_IN_SERIES,
        ],
        'name' => [
            'value' => 'Промо код',
            'type' => self::TYPE_STRING,
        ],
        'delta' => [
            'value' => 'Изменения цены',
            'type' => self::TYPE_STRING,
        ],
        'active' => [
            'value' => 'Активность',
            'type' => self::TYPE_BOOL,
        ],
    ];
    /**
     * Идентификатор
     *
     * @var Uuid
     */
    protected Uuid $id;

    /**
     * Промо код
     *
     * @var string
     */
    protected string $name;

    /**
     * Изменения цены
     *
     * @var DeltaPrice
     */
    protected DeltaPrice $delta;

    /**
     * Дата действия промо кода
     *
     * @var DateBetween
     */
    protected DateBetween $date;

    /**
     * Активность
     *
     * @var bool
     */
    protected bool $active;

    /**
     * Идентификатор фестиваля
     *
     * @var Uuid
     */
    protected Uuid $festival_id;

    /**
     * @param array $data
     *
     * @return self
     */
    public static function fromState(array $data): self
    {
        return (new self())
            ->setId(Uuid::import($data['id']))
            ->setName($data['name'])
            ->setDate(DateBetween::fromState($data))
            ->setActive((bool)$data['active'])
            ->setFestivalId(Uuid::import($data['festival_id']))
            ->setDelta(DeltaPrice::fromState($data));
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
     * @return PromoCode
     */
    public function setId(Uuid $id): PromoCode
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return PromoCode
     */
    public function setName(string $name): PromoCode
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DeltaPrice
     */
    public function getDelta(): DeltaPrice
    {
        return $this->delta;
    }

    /**
     * @param DeltaPrice $delta
     *
     * @return PromoCode
     */
    public function setDelta(DeltaPrice $delta): PromoCode
    {
        $this->delta = $delta;

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
     * @return PromoCode
     */
    public function setDate(DateBetween $date): PromoCode
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return PromoCode
     */
    public function setActive(bool $active): PromoCode
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Uuid
     */
    public function getFestivalId(): Uuid
    {
        return $this->festival_id;
    }

    /**
     * @param Uuid $festival_id
     *
     * @return PromoCode
     */
    public function setFestivalId(Uuid $festival_id): PromoCode
    {
        $this->festival_id = $festival_id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getColumnsList(): array
    {
        return self::COLUMNS_LIST;
    }
}
