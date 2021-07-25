<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Service\Factory;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use InvalidArgumentException;

/**
 * Class FilterDate
 *
 * Класс фильтрации по дате
 *
 * @package App\Ticket\Filter\Service\Factory
 */
final class FilterDate extends FilterFieldsAbstract
{
    /**
     * Фильтрация
     *
     * @param Builder|BuilderQuery $builder
     *
     * @return Builder|BuilderQuery
     * @throws Exception
     *
     */
    public function filtration($builder)
    {
        $value = $this->filterItem->getValue();

        return $builder->whereDate(
            $this->getFieldForWhere(),
            '=',
            self::getValidValue($value)->toDateString()
        );
    }

    /**
     * Выдать значения для фильтрации
     *
     * @param mixed $value
     *
     * @return Carbon
     * @throws Exception
     *
     * @throws InvalidArgumentException
     */
    protected static function getValidValue($value): Carbon
    {
        $date = new Carbon($value);
        $errors = $date::getLastErrors();

        if (is_array($errors) && isset($errors['errors']) && count($errors['errors']) > 0) {
            throw new InvalidArgumentException(
                "{$value} not DateType. Error: " . implode(PHP_EOL, $errors['errors'])
            );
        }

        return $date;
    }
}
