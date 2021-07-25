<?php

declare(strict_types=1);

namespace App\Ticket\Entity;

/**
 *
 * Interface EntityDataInterface
 *
 * Интерфейс дата сущности
 *
 * @package App\Ticket\Entity
 */
interface EntityDataInterface
{
    /**
     * Преобразовать значение сущности в строку
     *
     * @return mixed
     */
    public function __toString();

    /**
     * Высети сущность в виде json строки
     *
     * @return string
     */
    public function toJson(): string;
}
