<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Service\Factory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use InvalidArgumentException;

/**
 * Class FilterInteger
 *
 * Фильтрация по целому числу
 *
 * @package App\Tackit\Filter\Fields
 */
final class FilterInteger extends FilterFieldsAbstract
{
    /**
     * Фильтрация
     *
     * @param Builder|BuilderQuery $builder
     *
     * @return Builder|BuilderQuery
     */
    public function filtration($builder)
    {
        $value = $this->filterItem->getValue();

        return $builder->where($this->getFieldForWhere(), '=', self::getValidValue($value));
    }

    /**
     * Выдать значения для фильтрации
     *
     * @param mixed $value
     *
     * @return mixed
     * @throws InvalidArgumentException
     *
     */
    protected static function getValidValue($value)
    {
        if (!self::isValidValue($value)) {
            throw new InvalidArgumentException("{$value} not Intel Type");
        }

        return $value;
    }

    /**
     * Проверка на целое число
     *
     * @param mixed $value
     *
     * @return bool
     */
    private static function isValidValue($value): bool
    {
        return is_numeric($value);
    }
}
