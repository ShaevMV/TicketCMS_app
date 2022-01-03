<?php

declare(strict_types=1);

namespace Ticket\Shared\Domain\Entity;

use InvalidArgumentException;

/**
 * Class EntityService
 *
 * Сервис для сущностей
 *
 * @package App\Ticket\Entity
 */
class EntityService
{
    /**
     * Оставить не пустые поля
     *
     * @param EntityInterface $entity
     *
     * @return array
     * @throws InvalidArgumentException
     *
     */
    public static function getNotEmptyFields(EntityInterface $entity): array
    {
        $fields = array_filter($entity->toArray() ?? [], static function ($element) {
            return !empty($element);
        });

        if (count($fields) === 0) {
            throw new InvalidArgumentException('Fields empty');
        }

        return $fields;
    }
}
