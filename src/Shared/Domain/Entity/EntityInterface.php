<?php

declare(strict_types=1);

namespace Ticket\Shared\Domain\Entity;

use Webpatser\Uuid\Uuid;

/**
 * Interface EntityInterface
 *
 * Интерфейс для сущности
 *
 * @package App\Ticket\Entity
 *
 * @property Uuid $id
 */
interface EntityInterface
{
    /**
     * Создания сущности из массива
     */
    public static function fromState(array $data);

    /**
     * Преобразовать значения сущности в массив
     */
    public function toArray(): ?array;

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get(string $name);

    /**
     * Вывести объект в виде json
     */
    public function toJson(): string;
}
