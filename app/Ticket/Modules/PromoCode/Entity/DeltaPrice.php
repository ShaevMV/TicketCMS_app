<?php

declare(strict_types=1);

namespace App\Ticket\Modules\PromoCode\Entity;

use App\Ticket\Entity\AbstractionEntity;
use App\Ticket\Entity\EntityDataInterface;
use App\Ticket\Modules\PromoCode\Entity\Enum\DeltaTypeEnum;
use InvalidArgumentException;

/**
 * Class DeltaPrice
 *
 * Сущность цены промокода
 *
 * @package App\Ticket\Modules\PromoCode\Entity
 */
final class DeltaPrice extends AbstractionEntity implements EntityDataInterface
{
    private const COLUMNS_LIST = [
        'delta_price' => [
            'value' => 'Изменения цены',
            'type' => self::TYPE_INT,
        ],
        'delta_type' => [
            'value' => 'Тип изменения цены',
            'type' => self::TYPE_STRING,
        ],
    ];

    /**
     * Изменения цены
     *
     * @var int
     */
    protected int $delta_price;

    /**
     * Тип изменения цены (процент, скалярная)
     *
     * @var string
     */
    protected string $delta_type;

    /**
     * Получения сущности из статики
     *
     * @param array $data
     *
     * @return self
     */
    public static function fromState(array $data): self
    {
        if (!self::ensureIsValidDeltaType($data['delta_type'])) {
            throw new InvalidArgumentException("Type {$data['delta_type']} not valid");
        }

        if (!self::ensureIsValidDeltaPrice((int)$data['delta_price'])) {
            throw new InvalidArgumentException("Price {$data['delta_price']} not valid");
        }

        return (new self())
            ->setDeltaType($data['delta_type'])
            ->setDeltaPrice((int)$data['delta_price']);
    }

    /**
     * Проверить валидность типов
     *
     * @param string $deltaType
     *
     * @return bool
     */
    public static function ensureIsValidDeltaType(string $deltaType): bool
    {
        return DeltaTypeEnum::getKey($deltaType) !== false;
    }

    /**
     * Проверить валидность изменения цены
     *
     * @param int $deltaPrice
     *
     * @return bool
     */
    public static function ensureIsValidDeltaPrice(int $deltaPrice): bool
    {
        return $deltaPrice >= 0;
    }

    /**
     * Вывести строку из сущности
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->delta_price;
    }

    /**
     * @return int
     */
    public function getDeltaPrice(): int
    {
        return $this->delta_price;
    }

    /**
     * @param int $delta_price
     *
     * @return DeltaPrice
     */
    public function setDeltaPrice(int $delta_price): DeltaPrice
    {
        $this->delta_price = $delta_price;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeltaType(): string
    {
        return $this->delta_type;
    }

    /**
     * @param string $delta_type
     *
     * @return DeltaPrice
     */
    public function setDeltaType(string $delta_type): DeltaPrice
    {
        $this->delta_type = $delta_type;

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
