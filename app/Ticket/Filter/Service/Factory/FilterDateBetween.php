<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Service\Factory;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use InvalidArgumentException;

/**
 * Class FilterDateBetween
 *
 * Фильтрация промежутка дат
 *
 * @package App\Tackit\Filter\Fields
 */
final class FilterDateBetween extends FilterFieldsAbstract
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

        $dateArray = array_map(function (Carbon $item) {
            return $item->toDateString();
        }, self::getValidValue($value));

        return $builder->whereBetween($this->getFieldForWhere(), $dateArray);
    }

    /**
     * Выдать значения для фильтрации
     *
     * @param mixed $value
     *
     * @return Carbon[]
     * @throws InvalidArgumentException|Exception
     *
     */
    protected static function getValidValue($value): array
    {
        $result = [];
        foreach ($value as $item) {
            $date = new Carbon($item);
            $errors = $date::getLastErrors();

            if (is_array($errors) && isset($errors['errors']) && count($errors['errors']) > 0) {
                throw new InvalidArgumentException("{$item} not DateType. Error: {$errors['errors']}");
            }

            $result[] = $date;
        }

        return $result;
    }
}
