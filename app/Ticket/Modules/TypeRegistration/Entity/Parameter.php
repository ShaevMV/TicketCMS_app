<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Entity;

use InvalidArgumentException;

/**
 * Class Parameter
 *
 * Сущность параметров для типа билета
 *
 * @package App\Ticket\Modules\TypeRegistration\Entity
 */
final class Parameter
{
    /**
     * JSON Параметров
     *
     * @var string|null
     */
    private ?string $params;

    /**
     * Получения сущности из статики
     *
     * @param string|null $params
     *
     * @return Parameter
     */
    public static function fromState(?string $params): Parameter
    {
        if ($params !== null && !self::isValidate($params)) {
            throw new InvalidArgumentException("{$params} not format json");
        }

        return (new self())
            ->setParams($params);
    }

    /**
     * Валидация json строки параметров
     *
     * @param string $params
     *
     * @return bool
     */
    private static function isValidate(string $params): bool
    {
        json_decode($params);

        return json_last_error() == JSON_ERROR_NONE;
    }

    /**
     * @param string|null $params
     *
     * @return $this
     */
    public function setParams(?string $params): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Вывести параметры в массиве
     *
     * @return array
     */
    public function toArray(): array
    {
        return json_decode($this->params ?? '[]', true);
    }
}
