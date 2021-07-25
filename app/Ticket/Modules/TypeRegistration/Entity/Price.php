<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Entity;

use App\Ticket\Entity\AbstractionEntityData;
use InvalidArgumentException;

/**
 * Class Price
 *
 * Получения сущности цены типа билета
 *
 * @package App\Ticket\TypeRegistration\Entity
 */
final class Price extends AbstractionEntityData
{
    /**
     * Цена типа билета
     *
     * @var int
     */
    protected int $price;

    /**
     * @param int $price
     *
     * @return Price
     */
    public static function fromState(int $price): self
    {
        return (new self())
            ->setPrice($price);
    }

    /**
     * @param int $price
     *
     * @return Price
     */
    public function setPrice(int $price): Price
    {
        if (!self::isValid($price)) {
            throw new InvalidArgumentException("{$price} price not valid");
        }

        $this->price = $price;
        return $this;
    }

    /**
     * Проверка на положительную цену
     *
     * @param int $price
     *
     * @return bool
     */
    private static function isValid(int $price): bool
    {
        return $price >= 0;
    }

    /**
     * @return int
     */
    public function getInt(): int
    {
        return $this->price;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return (string)$this->price;
    }
}
