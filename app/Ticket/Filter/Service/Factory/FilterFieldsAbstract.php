<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Service\Factory;

use App\Ticket\Filter\Entity\FilterItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use InvalidArgumentException;

/**
 * Class FilterFieldsAbstract
 *
 * Общий класс для фильтров
 *
 * @package App\Tackit\Filter\Fields
 */
abstract class FilterFieldsAbstract
{
    /**
     * Сущность значений для фильтра
     *
     * @var FilterItem
     */
    protected FilterItem $filterItem;

    /**
     * FilterFieldsAbstract constructor.
     *
     * @param FilterItem $filterItem
     */
    public function __construct(FilterItem $filterItem)
    {
        $this->filterItem = $filterItem;
    }

    /**
     * Вывести значения сущности
     *
     * @return FilterItem
     */
    final public function getFilterItem(): FilterItem
    {
        return $this->filterItem;
    }

    /**
     * Вывести значения по котором осуществляется фильтрация
     *
     * @return mixed
     */
    final public function getValue()
    {
        return static::getValidValue($this->filterItem->getValue());
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
    abstract protected static function getValidValue($value);

    /**
     * Фильтрация
     *
     * @param Builder|BuilderQuery $builder
     *
     * @return Builder|BuilderQuery
     */
    abstract public function filtration($builder);

    /**
     * Вывести поле с добавленным именем таблицы
     *
     * @return string table.fields
     */
    final protected function getFieldForWhere(): string
    {
        return "{$this->filterItem->getTable()}.{$this->filterItem->getField()}";
    }
}
