<?php

declare(strict_types=1);

namespace App\Ticket\Entity;

use Webpatser\Uuid\Uuid;

/**
 * Interface EntityInterface
 *
 * Интерфейс для сущности
 *
 * @package App\Ticket\Entity
 *
 * @property Uuid $id
 * @property string $title
 */
interface EntityInterface
{
    /**
     * Создания сущности из массива
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function fromState(array $data);

    /**
     * Преобразовать значения сущности в массив
     *
     * @return array|null
     */
    public function toArray(): ?array;

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get(string $name);

    /**
     * Высети объект в виде json
     *
     * @return string
     */
    public function toJson(): string;
}
