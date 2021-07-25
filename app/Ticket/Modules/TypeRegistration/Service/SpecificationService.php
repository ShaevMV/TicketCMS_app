<?php

declare(strict_types=1);

namespace App\Ticket\Modules\TypeRegistration\Service;

use App\Ticket\Modules\TypeRegistration\Entity\Parameter;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationCount;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationInterface;
use InvalidArgumentException;

/**
 * Class SpecificationService
 *
 * Сервис работы со спецификацией типов билетов
 *
 * @package App\Ticket\Modules\TypeRegistration\Service
 */
final class SpecificationService
{
    /**
     * Ключ параметра типа билета по кол-ву
     *
     * @const string
     */
    public const KEY_COUNT = 'count';

    /**
     * Список всех ключей параметров
     *
     * @const array
     */
    private const ARRAY_KEY = [
        self::KEY_COUNT,
    ];

    /**
     * Получения списка спецификаций из параметров типа билета
     *
     * @param Parameter|null $parameter
     *
     * @return SpecificationInterface[]
     */
    public function createList(?Parameter $parameter): array
    {
        if (null === $parameter) {
            return [];
        }

        $result = [];

        foreach ($parameter->toArray() as $key => $value) {
            switch ($key) {
                case self::KEY_COUNT:
                    $result[] = new SpecificationCount($value);
                    break;
                default:
                    throw new InvalidArgumentException(
                        "Invalid key specification {$key}. The array " .
                        implode(" ", self::ARRAY_KEY) . " does not contain"
                    );
            }
        }

        return $result;
    }
}
